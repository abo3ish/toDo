@extends('layouts.master')

@section('content')
    <div class="todo" id="todo">
        <h1>TO DO </h1>
        <div class="list wrap" id="list">
            <ul id="tasks">
                @foreach($tasks as $task)
                <li class="tasks" >
                    <span class= "<?php echo ($task->done) ? 'done' : '' ?>">{{$task->name}}</span>

                    <a  class="float-left delete" data="{{$task->id}}">
                        <i class="fas fa-times"></i>
                    </a>
            
                    
                    <a  class="float-left edit-task"  data="{{$task->id}}" data-toggle="modal" data-target="#editTask">
                        <i class="far fa-edit"></i>
                    </a>  

                    @if($task->done == 0)
                    <a  class="float-left done" data="{{$task->id}}">
                        <i class="fas fa-check"></i>
                    </a>
                    @else
                    <a  class="float-left undo" data="{{$task->id}}">
                       <i class="fas fa-undo"></i>
                    </a>
                        
                    @endif
                </li>
                @endforeach
            
            </ul>
        </div>

        <div class="add-new">
            <form>
                {{ csrf_field() }}
                <input type="text" id="task-text" class="form-control" placeholder="Enter Your Task">
                <button id="add-new" class="form-control">Add new Task</button>
            </form>
        </div>

    </div>

<!-- start modal for editing task -->
    <!-- Modal -->
    <div class="modal fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="editTaskLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">
                    <input type="text" data="" id="task-text" class="form-control" placeholder="Enter Your Task">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="saveChanges" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
<!-- end modal for editing task -->
@endsection

@section('script')
    <script>
    // adding new task
    $(function(){

        //Adding new task
        $(document).on('click','.add-new #add-new',function(event){
            event.preventDefault();
            var taskText = $("#task-text").val();

            $.ajax({
                url: '{{ url('create') }}',
                type: 'post',
                data: {taskText : taskText, '_token': '{{ csrf_token() }}' }
            }).done(function(data){
                $("#task-text").val("");
                $(".list").load(location.href + ' #list');
                console.log(data);
            });
        });

        // showing the task text inside the input for editing
        $(document).on('click','.edit-task',function(event){

            event.preventDefault();

            var task    = $(this).siblings('span').text();
            var taskID  = $(this).attr('data');
            
            $(".modal-body #task-text").val(task);
            $(".modal-body #task-text").attr('data',taskID);

        });            

        // editing task text
        $(document).on('click',"#saveChanges",function(){

            var editedTask  = $(".modal-body #task-text").val();
            var taskID      = $(".modal-body #task-text").attr('data');
            

            $.ajax({

                url: '{{ url('edit') }}',
                type: "post",
                data: { '_token': '{{ csrf_token() }}', taskID : taskID, editedTask : editedTask }

            }).done(function(data){
               $(".list").load(location.href + ' #tasks'); 
            });
        });
        
        // task is done
        $(document).on('click','.done',function(event){
            event.preventDefault();
            var taskID = $(this).attr('data');
            $.ajax({
                url: '{{url('done')}}',
                type: 'post',
                data: { '_token': '{{ csrf_token() }}', taskID : taskID}
            }).done(function(data){
                $(".list").load(location.href + ' #tasks'); 
            });
        });

        // deleting task
        $(document).on('click','.delete',function(event){
            event.preventDefault();
            var taskID = $(this).attr('data');
            console.log(taskID);
            $.ajax({
                url: '{{url('delete')}}',
                type: 'post',
                data: { '_token': '{{ csrf_token() }}', taskID : taskID}
            }).done(function(data){
                $(".list").load(location.href + ' #tasks'); 
            });
        });

        //undo task
        $(document).on('click','.undo',function(event){
            event.preventDefault();
            var taskID = $(this).attr('data');
            $.ajax({
                url: '{{url('undo')}}',
                type: 'post',
                data: { '_token': '{{ csrf_token() }}', taskID : taskID}
            }).done(function(data){
                $(".list").load(location.href + ' #tasks'); 
            });
        });
        // scroll nice
        $(".wrap").niceScroll({
            cursorcolor: "rgba(0,0,0,.4)",
            cursorborder: 0,
            cursorborderradius: '5px'
        });
            
    });
        
        
    </script>
@endsection('script')