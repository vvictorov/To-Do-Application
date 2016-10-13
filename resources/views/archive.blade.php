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
                    @endforeach
                    <br/>
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-danger pull-right" style="margin:5px;" onclick="deleteList({{$list->id}});">Delete list</button>
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
    </script>
@endsection
