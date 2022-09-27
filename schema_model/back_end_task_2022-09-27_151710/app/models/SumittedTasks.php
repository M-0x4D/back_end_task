<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SumittedTasks extends Model 
{

    protected $table = 'submitted_tasks';
    public $timestamps = true;
    protected $fillable = array('task_id', 'user_id');

    public function user()
    {
        return $this->belongsTo('App\models\NewUser');
    }

}