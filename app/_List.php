<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _List extends Model
{

    protected $table = 'lists';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function task()
    {
        return $this->hasMany('App\Task','list_id');
    }
}
