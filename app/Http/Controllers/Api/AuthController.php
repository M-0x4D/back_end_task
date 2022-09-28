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

    // register new employee 
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
             return json_response( 0 , 'failed' , 'validation error');
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
            return json_response( 1 , 'success' , $user);
                
            }

    }


    // register new supervisor
    function register_supervisor(Request $request)
    {

        $validator = validator()->make($request->all() , [
            'name' => 'required',
            'email' => ['required' , 'unique:new_users'],
            'password' => 'required',
        ]);

       

        if ($validator->fails()) {
            # code...
             return json_response( 0 , 'failed' , 'validation error');
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






    // login function
    function login(Request $request)
    {
        $validator = validator()->make($request->all() , [

            'email' => 'required',
            'password' => 'required',
            
        ]);

        if ($validator->fails()) 
        {
            
             return json_response( 0 , 'failed' , 'validation error');
        }
        else 
        {
            $user = NewUser::where('email' , $request->email)->first();

            if($user)
            {
                if(Hash::check($request->password , $user->password))
                {
                    return json_response( 1 , 'success' , ['api_token' => $user->api_token , 'user'=>$user]);

                }
                else
                {
                    return json_response( 0 , 'failed' , 'wrong password');
                }           
            }
            else
            {
                return json_response( 0 , 'failed' , 'wrong email or the user does not exist ');
            }      

        }

    }






    // reset pin code to send it in email to user who need to reset his password or forgot it 
    function reset_pin_code(Request $request)
    {
        $user = $request->user();
        
        $code = rand(1111 , 9999);
        $update = $user->update(['pin_code' => $code]);
        if ($update) {
            // send mail...
            Mail::to(env('MAIL_LOG_CHANNEL'))->send(new ResetPassword($code));
            return json_response( 1 , 'success' , ['password reset with code : ' . $code , 'fails' => Mail::failures()]);
        }
        else {
            
            return json_response( 0 , 'failed' , 'user does not exist');;
        }

    }






    // reset or change the password from user
    function reset_password(Request $request)
    {
        if ($request->pin_code == $request->user()->pin_code && $request->password === $request->confirm_password) {
            # code...
            $user = $request->user();
            $update = $user->update(['password' =>  bcrypt($request->password) , 'pin_code' => NULL ]);
            return json_response( 1 , 'success' , 'تم تغيير الباسوورد بنجاح' );
        }
        else {
            
            return json_response( 0 , 'failed' , 'فشل في تغيير كلمه السر' );
        }
        
    }







    // logout
    function logout(Request $request)
    {
        $project = NewUser::where('api_token' , $request->api_token)->update([

            'api_token' => Str::random(60)
        ]);
        
        return json_response(1 , 'success' , 'Successfully logged out');
    }


}
