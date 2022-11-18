@extends('ui.layouts.user')

@section('view')

    <div class="card" style="width: 65em">

        <div class="card-body">
            <div style="display: inline-flex">
                <div class="pl-3"><h5 class="card-title">Tasks</h5></div>

            </div>

            <hr style="color: #0abfe6">
            <p class="card-text">This are All the tasks .</p>
        </div>

        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Task Name</th>
                <th>Task Description</th>
                <th>Due date</th>
                <th>Status</th>
                <th>Owner</th>

                <th >Action</th>
            </tr>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->task_description }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->user->first_name }}</td>
                    <td>
                        <form action="{{ route('tasks.destroy',$task->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('tasks.show',$task->id) }}">Show</a>



                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
    <br>


    @yield('')
@endsection
