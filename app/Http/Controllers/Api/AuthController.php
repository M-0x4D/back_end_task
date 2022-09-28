<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\models\NewUser;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    function register_employee(Request $request)
    {

        $validator = validator()->make($request->all() , [
            'name' => 'required',
            'email' => ['required' , 'unique:new_users'],
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

       

        if ($validator->fails()) {
            # code...
             return json_response(0 , 'failed' , 'validation error');
        }

        else {
               
            $password = Hash::make($request->password);
            $api_token = Str::random(60);
            $credentials = [
                'name' => $request->name , 
                'email' => $request->email , 
                'password' => $password , 
                'api_token' => $api_token
            ];
            $user = NewUser::create($credentials);
            $user->assignRole('employee');
            $user->save();
            return json_response(1 , 'success' , $user);
                
            }

    }


    function register_supervisor(Request $request)
    {

        $validator = validator()->make($request->all() , [
            'name' => 'required',
            'email' => ['required' , 'unique:new_users'],
            'password' => 'required',
        ]);

       

        if ($validator->fails()) {
            # code...
             return json_response(0 , 'failed' , 'validation error');
        }

        else {
               
            $password = Hash::make($request->password);
            $api_token = Str::random(60);
            $credentials = [
                'name' => $request->name , 
                'email' => $request->email , 
                'password' => $password , 
                'api_token' => $api_token
            ];
            $user = NewUser::create($credentials);
            $user->assignRole('supervisor');
            $user->save();
            return json_response(1 , 'success' , $user);

            }
    }







    function login(Request $request)
    {

        $validator = validator()->make($request->all() , [

            'email' => 'required',
            'password' => 'required',
            
        ]);


        if ($validator->fails()) 
        {
            
             return json_response(0 , 'failed' , 'validation error');
        }

        else 
        {

            $user = NewUser::where('email' , $request->email)->first();

            if($user)
            {
                if(Hash::check($request->password , $user->password))
                {
                    return json_response(1 , 'success' , ['api_token' => $user->api_token , 'user'=>$user]);

                }
                else
                {
                    return json_response(0 , 'failed' , 'wrong password');
                }
            
            
            }
            else
            {
                return json_response(0 , 'failed' , 'wrong email or the user does not exist ');
            }
           

        }

    }



    function logout(Request $request)
    {
        $project = NewUser::where('api_token' , $request->api_token)->update([

            'api_token' => Str::random(60)
        ]);
        
        return json_response(1 , 'success' , 'Successfully logged out');
    }


}
