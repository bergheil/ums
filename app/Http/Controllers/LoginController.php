<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

define ('ADMIN_GROUP', 1);

class LoginController extends Controller
{
    public function showLogin() {
        // show the form
        //return View::make('login');
        return view('login');
    }

    public function doLogin() {
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );
    
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return \Redirect::to('login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            // create our user data for the authentication
            $userdata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password')
            );

            $user = \DB::table('users')
                ->where('email', $userdata['email'])
                ->where('password',$userdata['password'])
                ->first();

            if ($user) {                
                session(['users' =>  $userdata['email']]);
                $admin = \DB::table('users_groups')
                    ->where('user_id', $user->id)
                    ->where('group_id', ADMIN_GROUP)
                    ->first();
                if ($admin) {
                    session(['isadmin' =>  true]);                    
                }
                return \Redirect::to('welcome');
            } else {
                return \Redirect::to('login')->withErrors("Authentication failed.");
            }
        }
    }
}
