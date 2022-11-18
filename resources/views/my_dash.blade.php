@extends('ui.layouts.user')

@section('view')

    <div class="card" style="width: 65em">

        <div class="card-body">
            <div style="display: inline-flex">
                <div class="pl-3"><h5 class="card-title">My tasks</h5></div>
                <div class="pl-4">
                    <a class="btn btn-primary" href="{{ route('tasks.create') }}"> Add task</a>
                </div>
            </div>

            <hr style="color: #0abfe6">
            <p class="card-text">This are my tasks in queue.</p>
        </div>

        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Task Name</th>
                <th>Task Description</th>
                <th>Due date</th>
                <th>Due date</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->task_description }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        <form action="{{ route('tasks.destroy',$task->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('tasks.show',$task->id) }}">Show</a>

                            <a class="btn btn-primary" href="{{ route('tasks.edit',$task->id) }}">Edit</a>

                            <input data-id="{{$task->id}}" class="toggle-class" type="checkbox" data-onstyle="success"
                                   data-offstyle="danger" data-toggle="toggle" data-on="Active"
                                   data-off="Inactive" {{ $task->status ? 'checked' : '' }}>


                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
    <br><br>
    <div class="card" style="width: 65em">

        <div class="card-body">
            <h5 class="card-title" style="color: #857b26">doing</h5>
            <hr>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Task Name</th>
                <th>Task Description</th>
                <th>Due date</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->task_description }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>
                        <form action="{{ route('tasks.destroy',$task->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('tasks.show',$task->id) }}">Show</a>


                            <a class="btn btn-primary" style="background-color: #0abfe6" href="{{ route('tasks.edit',$task->id) }}">finish</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
    <br><br>
    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? doing:pending;
                var task_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/move',
                    data: {'status': status, 'task_id': task_id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })
        })
    </script>

    @yield('')
@endsection
