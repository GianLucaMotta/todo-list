<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    public $timestamps = false;
    protected $fillable = ['task', 'description', 'status'];
}
