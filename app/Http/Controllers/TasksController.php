<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\_List;
use App\Task;
use Auth;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addTask($list_id,Request $request)
    {
        $list = _List::find($list_id);
        if(Auth::user()->level == '1' or $list->user_id == Auth::user()->id) {
            $task = new Task;
            $task->body = $request->input('task');
            $task->user_id = Auth::user()->id;
            $task->list_id = $list_id;
            $task->status = 0;
            $task->save();
            return 'added';
        }
        return 'error';
    }

    public function changeStatus($id,Request $request)
    {
        $task = Task::find($id);
        if(Auth::user()->level == '1' or $task->user_id == Auth::user()->id) {
            if($request->input('setStatus') == 0)
            {
                $task->status = 0;
                $task->save();
            }
            else
            {
                $task->status = 1;
                $task->save();
            }
            return 'status changed';
        }
        return 'error';
    }

    public function delete($id)
    {
        $task = Task::find($id);
        if(Auth::user()->level == '1' or $task->user_id == Auth::user()->id)
        {
            Task::destroy($id);
            return 'deleted';
        }
        return 'error';
    }
}
