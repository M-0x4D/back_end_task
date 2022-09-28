<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Task;
use App\models\SumittedTasks;

class TasksController extends Controller
{

    // create new task by supervisor only and assign specific employees for it by << employee_id >>
    function create(Request $request)
    {
        $validator = validator()->make($request->all() , [

            'name' => 'required',
            'details' => 'required',
            'employee_id' => 'required' , 
            'project_id' => 'required'
            
        ]);


        if ($validator->fails()) 
        {      
             return json_response(0 , 'failed' , 'validation error');
        }
        else {
            
            $task = Task::create([
                'project_id' => $request->project_id ,
                'name' => $request->name , 
                'user_id' => $request->employee_id ,
                'details' => $request->details
            ]);
            return json_response(1 , 'success' , $task);
        }  

    }






    // view task by two users << employee and supervisor >>
    function view(Request $request)
    {

        $validator = validator()->make($request->all() , [

            'task_id' => 'required',
            
        ]);


        if ($validator->fails()) 
        {
            
             return json_response(0 , 'failed' , 'validation error');
        }
        else {
            
            $task = Task::find($request->task_id);
            return json_response(1 , 'success' , $task);
        }
   
    }






    // update task data by supervisor only
    function update(Request $request)
    {

        $validator = validator()->make($request->all() , [

            'task_id' => 'required',
            
        ]);

        if ($validator->fails()) 
        { 
             return json_response(0 , 'failed' , 'validation error');
        }
        else {
            
            $task = Task::where('id' , $request->task_id)->update([

                'name' => $request->name
            ]);
            return json_response(1 , 'success' , $task);
        }

        
    }






    // delete task by supervisor only
    function delete(Request $request)
    {

        $validator = validator()->make($request->all() , [

            'task_id' => 'required',
            
        ]);

        if ($validator->fails()) 
        { 
             return json_response(0 , 'failed' , 'validation error');
        }
        else {
            
            $task = Project::find($request->task_id);
 
            $task->delete();

            return json_response(1 , 'success' , 'Task deleted successfully');
        }

        
    }







    // submit task by employee only and can't resubmit the same task again
    function submit(Request $request)
    {

        $validator = validator()->make($request->all() , [
            
            'task_id' => 'required',
            
        ]);

        if ($validator->fails()) 
        { 
             return json_response(0 , 'failed' , 'validation error');
        }
        else {
            
            $tsk = SumittedTasks::find($request->task_id);
        if ($tsk) {
            
            if ($tsk->user_id == auth()->guard('api')->user()->id) {
                
                return json_response(0 , 'failed' , 'you can not resubmit this task');
            }
            else {
                $submitted_task = SumittedTasks::update([
                    'task_id' => $request->task_id ,
                    'user_id' =>  auth()->guard('api')->user()->id ,
                ]);

                return json_response(1 , 'success' , $submitted_task);
            }
        }
        else {

            $submitted_task = SumittedTasks::create([
                'task_id' => $request->task_id ,
                'user_id' =>  auth()->guard('api')->user()->id ,
            ]);
            return json_response(1 , 'success' , $submitted_task);
        }
        }  
    }
    


    
}
