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
    function register(Request $request)
    {

        $validator = validator()->make($request->all() , [
            'name' => 'required',
            'email' => ['required' , 'unique:new_users'],
            'password' => 'required',
        ]);

       

        if ($validator->fails()) {
            # code...
             return response()->json("validation error");
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
            
           // $user->client_role()->attach(4 , ['model_type' => 'normal_user' , 'model_id' => $client->id]);
            return $user;
                
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
            
             return response()->json(['msg'=>"validation error"]);
        }

        else 
        {

            $user = NewUser::where('email' , $request->email)->first();

            if($user)
            {
                if(Hash::check($request->password , $user->password))
                {
                    return response()->json(['api_token' => $user->api_token , 'user'=>$user]);

                }
                else
                {
                    return response()->json(['msg' => 'failed1']);
                }
            
            
            }
            else
            {
                return response()->json(['msg' => 'failed2']);
            }
           

        }

    }


}
