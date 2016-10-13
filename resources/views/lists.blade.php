@extends('layouts.app')

@section('content')
    @foreach($lists as $list)
    <div class="container" id="list{{$list->id}}">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="list-head text-center">
                    <div class="row" style="line-height:40px;">
                        <div class="col-xs-4">by: {{$list->user->name}}</div>
                        <div class="col-xs-4"><h4 class="text-center">{{$list->name}}</h4></div>
                        <div class="col-xs-4">{{$list->created_at->format('d-m-Y')}}</div>
                    </div>
                </div>
                <div class="list-body">
                            <div class="row">
                                <div class="col-xs-3 text-center label task-head">Status</div>
                                <div class="col-xs-6 text-center label task-head">Task</div>
                                <div class="col-xs-3 text-center label task-head">Created</div>
                            </div>
                        </tr>
                    @foreach($list->task as $task)
                            <div class="row task" id="task{{$task->id}}" onclick="selectTask({{$task->id}});">
                                <div class="row">
                                    <div class="col-xs-3 text-center task-body">
                                        @if($task->status == 0)
                                            <div style="color:#0081ff;"><span class="glyphicon glyphicon-time"></span> In progress</div>
                                        @else
                                            <div style="color:#249024;"><span class="glyphicon glyphicon-ok-circle"></span> Completed</div>
                                        @endif
                                    </div>
                                    <div class="col-xs-6 text-center task-body">{{$task->body}}</div>
                                    <div class="col-xs-3 text-center task-body">{{$task->created_at->format('d-m-Y')}}</div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-12 text-center">
                                        @if($task->status == 0)
                                            <button type="submit" class="btn btn-success" style="margin:5px; display:none;" onclick="completeTask({{$task->id}});">Set complete</button>
                                        @else
                                            <button type="submit" class="btn btn-info" style="margin:5px; display:none;" onclick="setInProgress({{$task->id}});">Set in progress</button>
                                        @endif
                                        <button type="submit" class="btn btn-danger" style="margin:5px; display:none;" onclick="deleteTask({{$task->id}});">Delete task</button>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                    <div id="add-task-div{{$list->id}}" class="add-task-div" style="margin-bottom:10px; display:none;">
                        <br/>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                    <textarea class="form-control" rows="1" id="add-task-body{{$list->id}}"></textarea>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-success" onclick="addTask({{$list->id}});">Add</button>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4 text-center">
                            <button type="submit" class="btn btn-success" style="margin:5px;" onclick="addTaskField({{$list->id}});">Add task</button>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-warning" style="margin:5px;" onclick="archiveList({{$list->id}});">Archive list</button>
                            <button type="submit" class="btn btn-danger" style="margin:5px;" onclick="deleteList({{$list->id}});">Delete list</button>
                        </div>
                    </div>
                    @if($list->pendingDel == '1' and Auth::user()->level == 0)
                        <br/>
                        <div class="row">
                            <div id="list{{$list->id}}-msg" class="col-sm-12 text-center" style="color:#ff0000;">Pending administrator's confirmation to be deleted.</div>
                        </div>
                    @elseif($list->pendingDel == '1' and Auth::user()->level == 1)
                        <br/>
                        <div class="row">
                            <div id="list{{$list->id}}-msg" class="col-sm-12 text-center" style="color:#ff0000;">{{$list->user->name}} requested to delete this list</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
        <br/>
    </div>
    @endforeach
@endsection

@section('scripts')
    <script type="text/javascript">

        function deleteList(id){
            var r = confirm("Are you sure you want to delete this list?");
            if(r == true)
            {
                $.ajax({
                    url: '/deleteList/'+id,
                    type:'DELETE',
                    success: function(response) {
                        if(response == 'deleted')
                        {
                            $("#list"+id).fadeOut("slow");
                        }
                        else
                        {
                            location.reload();
                        }
                    },
                    error: 'An error has occured!'
                });
            }
        }

        function archiveList(id)
        {
            var r = confirm("Are you sure you want to archive this list?");
            if(r == true)
            {
                $.ajax({
                    url: '/archiveList/'+id,
                    type:'PATCH',
                    success: function(response) {
                        if(response == 'archived')
                        {
                            $("#list"+id).fadeOut("slow");
                        }
                        else
                        {
                            alert(response);
                        }
                    },
                    error: 'An error has occured!'
                });
            }
        }

        function selectTask(id)
        {
            $(".task").removeClass("task-active");
            $(".task .btn").css("display","none");
            $(".add-task-div").css("display","none");
            $("#task"+id).addClass("task-active");
            $("#task"+id+" .btn").css("display","inline");
        }

        function addTaskField(list_id)
        {
            $(".add-task-div").css("display","none");
            $("#add-task-div"+list_id).css("display","inline");
        }

        function addTask(list_id)
        {
            var task = $("#add-task-body"+list_id).val();
            if(task != "")
            {
                $.ajax({
                    url: '/addTask/'+list_id,
                    type:'PUT',
                    data: {
                        task : task
                    },
                    success: function(response) {
                        if(response == 'added')
                        {
                            location.reload();
                        }
                        else alert('response');
                    },
                    error: 'An error has occured!'
                });
            }
        }

        function completeTask(id)
        {
            $.ajax({
                url: '/taskChangeStatus/'+id,
                type:'POST',
                data: {
                    setStatus : '1'
                },
                success: function(response) {
                    if(response == 'status changed')
                    {
                        location.reload();
                    }
                    else alert('response');
                },
                error: 'An error has occured!'
            });
        }

        function setInProgress(id)
        {
            $.ajax({
                url: '/taskChangeStatus/'+id,
                type:'POST',
                data: {
                    setStatus : '0'
                },
                success: function(response) {
                    if(response == 'status changed')
                    {
                        location.reload();
                    }
                    else alert('response');
                },
                error: 'An error has occured!'
            });
        }

        function deleteTask(id)
        {
            var r = confirm("Are you sure you want to delete this task?");
            if(r == true)
            {
                $.ajax({
                    url: '/deleteTask/'+id,
                    type:'DELETE',
                    success: function(response) {
                        if(response == 'deleted')
                        {
                            $("#task"+id).fadeOut("slow");
                        }
                        else
                        {
                            location.reload();
                        }
                    },
                    error: 'An error has occured!'
                });
            }
        }
    </script>
@endsection
