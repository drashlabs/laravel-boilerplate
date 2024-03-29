<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WelcomeToken;
use App\Notifications\Auth\Welcome as WelcomeNotification;
use App\Traits\Utilities;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use \App\Http\Requests\NewUserRequest;
use \App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $this->authorize('users.index');

        if (request()->ajax()) {
            return DataTables::of(User::query())
                ->addColumn('name', function ($user) {
                    $name = $user->first_name.' '.$user->last_name;

                    if (Auth::user()->can('users.show')) {
                        return '
                            <a class="text-decoration-none" href="'.route('users.show', ['user' => $user->uuid]).'">'.$name.'</a>
                            <small class="float-right">'.$user->role.'</small>
                        ';
                    }

                    return $name;
                })
                ->rawColumns(['name'])
                ->toJson(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('users.create');

        return view('users.create', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\NewUserRequest  $request
     * @return Response
     */
    public function store(NewUserRequest $request)
    {
        $this->authorize('users.create');

        try {
            $user = User::create([
                'uuid' => $this->generateUuid(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($this->generateUuid()),
            ]);

            if (! is_null($request->roles)) {
                $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
                $user->assignRole($roles);
            }

            ($user->welcomeToken) && $user->welcomeToken->delete();

            WelcomeToken::create([
                'user_id' => $user->id,
                'token' => $this->generateUuid(),
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Database Error',
                ],
            ]);
        }

        try {
            $user->notify(new WelcomeNotification());

            return redirect()->route('users.show', ['user' => $user->uuid]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Notification Error',
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return Response
     */
    public function show(User $user)
    {
        ($user->uuid !== Auth::user()->uuid) && $this->authorize('users.show');

        return view('users.show', ['user' => $user ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $uuid
     * @return Response
     */
    public function edit(User $user)
    {
        ($user->uuid !== Auth::user()->uuid) && $this->authorize('users.edit');

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all(),
            'currentRoles' => $user->roles()->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  string  $uuid
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        ($user->uuid !== Auth::user()->uuid) && $this->authorize('users.edit');

        try {
            if ($request->email !== $user->email) {
                $user->update([
                    'email' => $request->email,
                    'email_verified_at' => null,
                ]);

                $user->sendEmailVerificationNotification();
            }

            $user->update($request->only('first_name', 'last_name'));

            $roles = (is_null($request->roles)) ? [] : Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $user->syncRoles($roles);

            return redirect()->route('users.show', ['user' => $user->uuid]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Database Error',
                ],
            ]);
        }
    }

    /**
     * Show the view for deleting the specified resource.
     *
     * @param  string  $uuid
     * @return Response
     */
    public function delete(User $user)
    {
        $this->authorize('users.delete');

        // You cannot delete your own account.
        ($user->uuid === Auth::user()->uuid) && abort(403);

        return view('users.delete', [ 'user' => $user ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return Response
     */
    public function destroy(User $user)
    {
        $this->authorize('users.delete');

        ($user->uuid === Auth::user()->uuid) && abort(403);

        try {
            $user->delete();
            return redirect()->route('users.index');
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Database Error',
                ],
            ]);
        }
    }
}
