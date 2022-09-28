<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Project;

class ProjectsController extends Controller
{
    // create new project by supervisor only
    function create(Request $request)
    {
        $validator = validator()->make($request->all() , [

            'name' => 'required',
            'details' => 'required',
            
        ]);

        if ($validator->fails()) 
        {
            
             return json_response(0 , 'failed' , 'validation error');
        }
        else {
            
            $project = Project::create([
                'name' => $request->name , 
                'user_id' => auth()->guard('api')->user()->id ,
                'details' => $request->details
            ]);
            return json_response(1 , 'success' , $project);
        }

    }




    // view project by supervisor only
    function view(Request $request)
    {

        $validator = validator()->make($request->all() , [

            'project_id' => 'required',
            
        ]);


        if ($validator->fails()) 
        {
            
             return json_response(0 , 'failed' , 'validation error');
        }
        else {
            
            $project = Project::find($request->project_id);
            return json_response(1 , 'success' , $project);
        }
    }







    // update project data by supervisor only
    function update(Request $request)
    {

        $validator = validator()->make($request->all() , [

            'project_id' => 'required',
            
        ]);

        if ($validator->fails()) 
        {    
             return json_response(0 , 'failed' , 'validation error');
        }
        else {
            
            $project = Project::where('id' , $request->project_id)->update([

                'name' => $request->name
            ]);
            return json_response(1 , 'success' , $project);
        }
    }




    // delete project by supervisor only
    function delete(Request $request)
    {
        $validator = validator()->make($request->all() , [

            'project_id' => 'required',
            
        ]);

        if ($validator->fails()) 
        {    
             return json_response(0 , 'failed' , 'validation error');
        }
        else {

            $project = Project::find($request->project_id);
            $project->delete();
            return json_response(1 , 'success' ,'project deleted successfully');
        }
        
    }
}
