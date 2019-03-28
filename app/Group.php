<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This class is the Model representation of the Group table in the ORM Laravel system.
 */
class Group extends Model
{
    /**
     * Return the list of the users in the group
     * @return object List of User object
     */
    public function userConnected() {
        $users = \DB::table('users')         
            ->join("users_groups", "users_groups.user_id", "=", "users.id")   
            ->where('users_groups.group_id', $this->id)
            ->count();
        return (int)$users;
    }
}
