<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>


## Laravel sample application - User Management System

Simple app written in Laravel for user management. The app uses a SQLite database stored in the database file **database\database.sqlite**.
Here you can find a simple graph illustrating the [domain model](./resources/assets/other/UMS-Domain_model.png) and the [ER Database chart](./resources/assets/other/UMS-Domain_model.png).


## Stories

This app implements the following stories.
- As an admin I can add users — a user has a name.
- As an admin I can delete users.
- As an admin I can assign users to a group they aren’t already part of.
- As an admin I can remove users from a group.
- As an admin I can create groups.
- As an admin I can delete groups when they no longer have member

## Rest API

In the **routes/web.php** file you can find the Rest API related to the operations indicated in the stories.
The rest API uses **controllers** that implement the features required in the stories. 
The controllers are:
- **LoginController**: implements the login API
- **UserController**: implements the user/group API

## Html page view

HTML pages have been implemented that represent the font-end of the application and are the following:
- **welcome**: home page
- **login**: login page and list of users
- **groups**: list of the groups


## Sequence of operations to build the project from scratch

- Creating the project using composer  
  In the terminal: *composer create-project --prefer-dist laravel/laravel ums*

- Configuration of Sqlite database  
  Edit the file **.env** and write the path of the file in **DB_DATABASE** variable

- Create database tables
  You must edit the file in database/migrations to change the columns of the default users table and adding some users as default.
  After that you need to create a group table with the following teminal command:  
  *php artisan make:migration create_groups_table --create=groups*  
  and  edit the new file with the Laravel ORM syntax, adding some groups as default.
  After that you need to create a table users_groups with the command:  
  *php artisan make:migration create_users_group_table --create=users_groups*  
  and edit the generated file.
  To create the database structure and data you should use the terminal command:  
  *php artisan migrate*

- Create model classes for the database objects with the following commands:  
  *php artisan make:model User*  
  *php artisan make:model Group*  
  *php artisan make:model UsersGroup*  

- You need to create the API controller using the following terminal command   
  *php artisan make:controller LoginController*  
  *php artisan make:controller UserController*  

- Now you can write the API in the file **route/web.php**

- Create the php view page modifying and cloning the file **views/welcome.blade.php**

- Try the web app using the followind terminal command: *php artisan serve*

## How to access to data Model (for programmers)
You can manipulate data using a very useful terminal php shell using the command *php artisan tinker*
and try this code example.
- View all users in database  
  *\App\User::all();*

- Find a user with the id = 1  
  *\App\User::find(1);*

- Create a new user
  *$new = new \App\User();*  
  *$new->name="Sansa Stark";*  
  *$new->email="sansa@domain.com";*  
  *$new->password="pwd";*  
  *$new->save();*  
  *echo $new;*  

- Get all the user of admin group  
  *\DB::table('users')->join("users_groups", "users_groups.user_id", "=", "users.id")->where('users_groups.group_id', 1)->select("users.id","users.name")->get();*

## Unit test environment
For testing purpose an "in memory" database is created with the same initial data (phpunit, see config file .env.testing).
