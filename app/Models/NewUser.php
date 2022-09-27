<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class NewUser extends Model 
{

    protected $table = 'new_users';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'password', 'api_token', 'pin_code');

    public function tasks()
    {
        return $this->hasMany('App\models\Task');
    }

    public function projects()
    {
        return $this->hasMany('App\models\Project');
    }

    public function submitted_tasks()
    {
        return $this->hasMany('App\models\SumittedTasks');
    }


    public function user_role()
{
    return $this->belongsToMany('App\models\Role');
}


protected $hidden = [
    'password',
    'api_token',
];

}