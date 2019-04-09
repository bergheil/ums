<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Group;

class UserGroupTest extends TestCase
{
    // Using this trait the database test is refreshed before tests
    use RefreshDatabase;
    
    /**
     *  Setup the testing database
     * */
    public function setUp() :void {
        parent::setUp();
        Artisan::call('migrate');        
    }

    /**
     * Test di method userConnected
     */
    public function testUserConnected() {
        $group_id = 1;
        $group = Group::find($group_id);
        $user_id = $group->userConnected();
        $expected_id = \DB::table('users')         
            ->join("users_groups", "users_groups.user_id", "=", "users.id")   
            ->where('users_groups.group_id', $group_id)
            ->count();

        $this->assertEquals($expected_id, $user_id, "The user {$expected_id} is not equal to {$user_id}");
    }

}