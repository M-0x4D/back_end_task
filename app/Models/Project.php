<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model 
{

    protected $table = 'projects';
    public $timestamps = true;
    protected $fillable = array('name', 'user_id', 'details');

    public function tasks()
    {
        return $this->hasMany('App\models\Task');
    }

    public function user()
    {
        return $this->belongsTo('App\models\NewUser');
    }

}