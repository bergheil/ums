<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

/**
 * Implement all the API for the User management
 */
class UserController extends Controller
{
    /**
     * Delete user
     * @request object Request object
     * @id int Id of the user
     */
    public function destroy(Request $request, $id) {
        $result = \App\User::destroy($id);

        return $result ;
    }

    /**
     * Delete group
     * @request object Request object
     * @id int Id of the group
     */    
    public function destroyGroup(Request $request, $id) {
        $result = \App\Group::destroy($id);

        return $result ;
    }

    /**
     * Add a user
     * @request object Request object
     */
    public function add(Request $request) { 
        $newUser = new \App\User();
        $newUser->name = Input::get('name');
        $newUser->email = Input::get('email');
        $newUser->password = Input::get('password');
        $newUser->save();        

        $userGroup = new \App\UsersGroup();
        $userGroup->user_id = $newUser->id;
        $userGroup->group_id = Input::get('group');
        $userGroup->save();

        return $newUser;
    }


    /**
     * Add a group
     * @request object Request object
     */
    public function addGroup(Request $request) { 
        $newGroup = new \App\Group();
        $newGroup->name = Input::get('name');      
        $newGroup->save();
        return $newGroup;
    }

    /**
     * Modify group and reassign the user of the group
     * @request object Request object
     * @id int Id of the group
     */
    public function modifyGroup(Request $request, $id) { 
        $group = \App\Group::find($id);
        $group->name = Input::get('name');
        $group->save();
        // Change user-group relation
        \DB::table('users_groups')->where('group_id', '=', $id)->delete();
        if (Input::get('users')) {
            foreach (Input::get('users') as $utente) {
                \DB::table('users_groups')->insert(
                    array(                
                        'group_id' => $id,
                        'user_id' => $utente,
                    )
                );
            }
        }
        return $group;
    }    


    /**
     * Return the list of the users for each group.
     */
    public function listUsers(Request $request) {        
        $users = \DB::table('users')            
            ->leftJoin('users_groups', "users_groups.user_id", "=",  "users.id")            
            ->select('users.id', 'users.name', 'users_groups.group_id')
            ->get();            
        return $users;
    }
}
