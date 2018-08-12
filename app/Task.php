<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Task extends Eloquent
{
    //
    protected $connection = 'mongodb';
    protected $collection = 'tasks';
    
    protected $primaryKey = '_id';
	protected $fillable = ['title', 'description', 'due_date','completed'];
}
