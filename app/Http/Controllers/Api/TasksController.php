<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Task;
use App\models\SumittedTasks;

class TasksController extends Controller
{
    function create(Request $request)
    {
        $task = Task::create([
            'project_id' => $request->project_id ,
            'name' => $request->name , 
            'user_id' => $request->employee_id ,
            'details' => $request->details
        ]);
        return $task;

    }

    function view(Request $request)
    {

        $task = Task::find($request->task_id);
        return $task;
    }

    function update(Request $request)
    {

        $task = Task::where('id' , $request->task_id)->update([

            'name' => $request->name
        ]);
        return $task;
    }

    function delete(Request $request)
    {

        $task = Project::find($request->task_id);
 
        $task->delete();

        return "task deleted successfully";
    }

    function submit(Request $request)
    {

        $tsk = SumittedTasks::find($request->task_id);
        if ($tsk) {
            
            if ($tsk->user_id == auth()->guard('api')->user()->id) {
                
                return "you can not resubmit this task";
            }
            else {
                $submitted_task = SumittedTasks::update([
                    'task_id' => $request->task_id ,
                    'user_id' =>  auth()->guard('api')->user()->id ,
                ]);

                return $submitted_task;
            }
        }
        else {

            $submitted_task = SumittedTasks::create([
                'task_id' => $request->task_id ,
                'user_id' =>  auth()->guard('api')->user()->id ,
            ]);
            return $submitted_task;
            

        }

        

    }
    
}
