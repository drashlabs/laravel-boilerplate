@extends('ui.layouts.basic')

@section('content')
    <div class="">

        <div class="col-md-4 col-lg-3">
            @yield('view')

            @if(isset($user->id) && Route::currentRouteName() === 'users.show')
                <div class="clearfix px-4 pb-4 bg-white">
                    @if(Auth::user()->can('users.delete') && $user->id !== Auth::user()->id)
                        <a href="{{ route('users.delete', ['user' => $user->uuid]) }}"
                           class="card-link float-left text-danger">
                            <i class="fas fa-trash-alt" title="Delete"></i>
                        </a>
                    @endif
                    <a href="{{ route('users.edit', ['user' => $user->uuid]) }}" class="card-link float-right">
                        <i class="fas fa-edit" title="Edit"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
