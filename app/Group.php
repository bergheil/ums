<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function userConnected() {
        $users = \DB::table('users')         
            ->join("users_groups", "users_groups.user_id", "=", "users.id")   
            ->where('users_groups.group_id', $this->id)
            ->count();
        return (int)$users;
    }
}
