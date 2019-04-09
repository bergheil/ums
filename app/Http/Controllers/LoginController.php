<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

define ('ADMIN_GROUP', 1);

/**
 * Controller for Login API
 */
class LoginController extends Controller
{
    /**
     * Show the login Page
     */
    public function showLogin() {                
        return view('login');
    }

    /**
     * Make the authentication. 
     * If the user a password is correct write a session variabile "users" and "isadmin" for user in the admin group
     */
    public function doLogin(Request $request) {        
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
                ->withInput($request['password']); // send back the input (not the password) so that we can repopulate the form
        } else {
            // create our user data for the authentication
            $userdata = array(
                'email'     => $request['email'],
                'password'  => $request['password']
            );

            // check if there is a user with the email and password
            $user = \DB::table('users')
                ->where('email', $userdata['email'])
                ->where('password',$userdata['password'])
                ->first();

            // When success write session variable
            session(['isadmin' =>  false]); 
            if ($user) {                
                session(['users' =>  $userdata['email']]);
                $admin = \DB::table('users_groups')
                    ->where('user_id', $user->id)
                    ->where('group_id', ADMIN_GROUP)
                    ->first();
                if ($admin) {
                    session(['isadmin' =>  true]);                    
                } 

                // redirect to the home (list of users)
                return \Redirect::to('welcome');
            } else {
                // redirect to the login page
                return \Redirect::to('login')->withErrors("Authentication failed.");
            }
        }
    }
}
