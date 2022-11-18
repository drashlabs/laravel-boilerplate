<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::user()->id)->get();
        return view('task.index',compact('tasks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $userid = Auth::id();
        $request->validate([
            'task_name' => 'required',
            'task_description' => 'required',
            'due_date' => 'required',
        ]);
        $task = new Task;
        $task->task_name = $request->task_name;
        $task->task_description = $request->task_description;
        $task->due_date = $request->due_date;
        $task->user_id =$userid;
        $task->save();
        return redirect()->route('tasks.index')
            ->with('success','Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return Response
     */
    public function show(Task $task)
    {
        return view('task.show',compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return Response
     */
    public function edit(Task $task)
    {
        return view('task.edit',compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Task $task)
    {

        $request->validate([
            'task_name' => 'required',
            'task_description' => 'required',
            'due_date' => 'required',
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index')
            ->with('success','Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success','Task deleted successfully');
    }
    public function moveTodoing(Request $request)
    {
        $task = Task::find($request->task_id);
        $task->status = $request->status;
        $task->save();
        return response()->json(['success'=>'Status change successfully.']);

    }
    public function indexOfall()
    {
        $tasks = Task::latest()->paginate(5);
        return view('task.alltasks',compact('tasks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
