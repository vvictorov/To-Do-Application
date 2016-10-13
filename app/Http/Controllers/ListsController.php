<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\_List;
use App\Task;
use Auth;

class ListsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->level == 1)
        {
            $lists = _List::all()->where('archived',0);
            return view('lists',compact('lists'));
        }
        else
        {
            $lists = _List::all()->where('archived',0)->where('user_id',Auth::user()->id);
            return view('lists',compact('lists'));
        }
    }

    public function newlist()
    {
        return view('newlist');
    }

    public function archives_view()
    {
        if(Auth::user()->level == 1)
        {
            $lists = _List::all()->where('archived',1);
            return view('archive',compact('lists'));
        }
        else
        {
            $lists = _List::all()->where('archived',1)->where('user_id',Auth::user()->id);
            return view('archive',compact('lists'));
        }
    }

    public function addlist(Request $request)
    {
        $list = new _List;

        $list->name = $request->title;
        $list->user_id = Auth::user()->id;
        $list->archived = 0;

        $list->save();
        for($i=1;$i<=$request->tasks_num;$i++)
        {
            $task = new Task;

            $task->body = $request->{'task'.$i};
            $task->user_id = Auth::user()->id;
            $task->list_id = $list->id;
            $task->status = 0;

            $task->save();
        }
        return redirect('/');
    }

    public function delete($id)
    {
        $list = _List::find($id);
        if(Auth::user()->level == '1')
        {
            _List::destroy($id);
            return 'deleted';
        }
        else
        {
            if($list->user_id == Auth::user()->id)
            {
                $list->pendingDel = 1;
                $list->save();
                return 'pending';
            }
        }
    }

    public function archive($id)
    {
        $list = _List::find($id);
        $task_count = Task::where('list_id',$list->id)->count();
        if($task_count > 0)
        {
            if(Auth::user()->level == '1' or $list->user_id == Auth::user()->id)
            {
                $list->archived = 1;
                $list->save();
                return 'archived';
            }
            else return 'Denied!';
        }
        else return 'Lists without any tasks cannot be archived!';
    }
}
