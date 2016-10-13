<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function _list(){
        return $this->belongsTo('App\Task','list_id');
    }
}
