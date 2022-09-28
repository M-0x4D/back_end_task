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
