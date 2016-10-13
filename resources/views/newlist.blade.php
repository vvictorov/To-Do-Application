@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="list-head text-center">
                    <h4 style="line-height:40px; margin:0px;">Create a new list</h4>
                </div>
                <div class="list-body">
                    <form class="form-horizontal" action="/addlist" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="tasks_num" id="tasks_num" value="0">
                        <div style="margin:20px;">
                            <div class="form-group" style="margin-bottom:20px;">
                                <label class="control-label col-sm-2" for="title">Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="add-task-div" style="margin-bottom:10px;"></div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <div id="add-task"><span class="glyphicon glyphicon-plus"></span> Add a new task</div>
                                </div>
                            </div>
                            <br/>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success" style="margin:5px;">Create list</button>
                                <button type="reset" class="btn btn-danger" style="margin:5px;">Clear fields</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <br/>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
    $(document).ready(function(){
        var count = 1;
        $('#add-task').click(function(){
            var content =   '<div style="margin-bottom:5px;">' +
                                '<label class="control-label col-sm-2">Task ' + count + ':</label>' +
                                '<div class="col-sm-10">' +
                                    '<textarea class="form-control" rows="1" name="task'+ count +'"></textarea>' +
                                '</div><br/><br/>' +
                            '</div> ';
            $('#add-task-div').append(content);
            $('#tasks_num').val(count);
            count++;
        });
    });
    </script>
@endsection