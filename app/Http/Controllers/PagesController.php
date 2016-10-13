<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\_List;
use App\Task;
use Auth;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function admin()
    {
        if(Auth::user()->level == 1)
        {
            $lists = _List::all()->where('pendingDel',1);
            return view('admin',compact('lists'));
        }
        else
        {
            return redirect('/');
        }
    }
}
