<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model 
{

    protected $table = 'tasks';
    public $timestamps = true;
    protected $fillable = array('project_id', 'name', 'user_id', 'details');

    public function project()
    {
        return $this->belongsTo('App\models\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\models\NewUser');
    }

}