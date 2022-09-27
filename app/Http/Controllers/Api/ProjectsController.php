<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Project;

class ProjectsController extends Controller
{
    function create(Request $request)
    {
        $project = Project::create([
            'name' => $request->name , 
            'user_id' => auth()->guard('api')->user()->id ,
            'details' => $request->details
        ]);
        return $project;
        

    }

    function view(Request $request)
    {
        $project = Project::find($request->project_id);
        return $project;

    }

    function update(Request $request)
    {
        $project = Project::find($request->project_id);
        $project->update([
            'name' => $request->name , 
            'user_id' => auth()->guard('api')->user()->id ,
            'details' => $request->details
        ]);
        return $project;

    }

    function delete(Request $request)
    {

        $project = Project::find($request->project_id);
 
        $project->delete();
        return "project deleted successfully";
    }
}
