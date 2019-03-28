<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');            
            $table->timestamps();            
        });

        // Add some users
        DB::table('users')->insert(
            array(
                'email' => 'francesco.diperna@gmail.com',
                'name' => 'francesco',
                'password' => 'pwd'
            )
        );
        DB::table('users')->insert(            
            array(
                'email' => 'jhon.snow@gmail.com',
                'name' => 'Jhon',
                'password' => 'pwd'
            )
        );
        DB::table('users')->insert(            
            array(
                'email' => 'aria.stark@gmail.com',
                'name' => 'Aria Stark',
                'password' => 'pwd'
            )
        );
        DB::table('users')->insert(            
            array(
                'email' => 'brandon.stark@gmail.com',
                'name' => 'Brandon Stark',
                'password' => 'pwd'
            )
        );

        DB::table('users')->insert(            
            array(
                'email' => 'deneris.targarian@gmail.com',
                'name' => 'Denearis Targarian',
                'password' => 'pwd'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
