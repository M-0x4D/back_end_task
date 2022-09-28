<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Project;

class ProjectsController extends Controller
{
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
