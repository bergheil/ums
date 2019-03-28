<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ums</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: black;
                font-family: 'Inconsolata', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 34px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 90px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
          
            <div class="top-right links">
                @if (session('users'))
                    <a href="{{ url('/welcome') }}">Users</a>
                    <a href="{{ url('/groups') }}">Groups</a>
                    <a href="{{ url('/login') }}">Logout</a>
                @else
                    <a href="{{ url('/login') }}">Login</a>                        
                @endif
            </div>
        
            <div class="content">
                <div class="title m-b-md">
                    Welcome user <strong>{{ session('users') }}</strong>
                    @if (session('isadmin'))  
                         - You are <strong>Admin user</strong>
                    @endif
                </div>
                <div id="errorMsg"></div>
                <div id="confirmMsg"></div>
                @if (session('isadmin'))     
                    <div>                        
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add user</button>          
                    </div>    
                    <table class="table table-hover"> 
                        <thead>                            
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Operation</th>
                            </tr>
                        </thead>              
                        <tbody>                            
                    @foreach (App\User::all() as $user)
                            <tr id="row_{{ $user->id }}">
                                <th scope="row">{{ $user->id }}</th>
                                <td align="left">{{ $user->name }}</td>
                                <td align="left">{{ $user->email }}</td>
                                <td align="left">
                                    <a style="cursor:pointer" data-id="{{ $user->id }}" class="delete" title="Delete user" target="_blank">
                                        <i class="fa fa-trash fa-2x"></i>
                                    </a>
                                </td>
                            </tr>                                                
                    @endforeach             
                        </tbody>
                    </table>
                @endif
                
            </div>
        </div>

        <!-- Modal -->
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Add user</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fas fa-user prefix grey-text"></i>
                        <input type="text" id="form_name" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="form_name">Name</label>
                    </div>

                    <div class="md-form mb-5">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <input type="email" id="form_email" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="form_email">Email</label>
                    </div>

                    <div class="md-form mb-5">
                            <i class="fas fa-password prefix grey-text"></i>
                            <input type="password" id="form_password" class="form-control validate">
                            <label data-error="wrong" data-success="right" for="form_password">Password</label>
                    </div>

                    <div class="md-form mb-5">
                            <i class="fas fa-password prefix grey-text"></i>                            
                            <select id="form_group" class="form-control validate">
                                @foreach (App\Group::all() as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>                                    
                                 @endforeach        
                            </select>
                            <label data-error="wrong" data-success="right" for="form_group">Group</label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-success" id="addButton">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
                </div>
                </div>
            </div>
        </div>

        <script>
                $(".delete").click(function(){
                    var id = $(this).data("id");   
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax(
                    {
                        url: "user/delete/"+id,
                        type: 'DELETE',
                        dataType: "JSON",
                        data: {
                            "id": id,
                            "_method": 'DELETE',                            
                        },
                        success: function ()
                        {                            
                            $('#row_' + id).remove();
                            $('#confirmMsg').html("<div class=\"alert alert-success\">User deleted</div>");
                        },
                        error:function(msg){
                            $('#errorMsg').html("<div  class=\"alert alert-danger\">Sorry. I cannot delete the user!</div>");
                        }
                    });                    
                });  

                $("#addButton").click(function(){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax(
                    {
                        url: "user/add",
                        type: 'POST',
                        dataType: "JSON",
                        data: {
                            "name": $('#form_name').val(),
                            "email": $('#form_email').val(),
                            "password": $('#form_password').val(),
                            "group": $('#form_group').val(),
                        },
                        success: function ()
                        {                         
                            $('#myModal').modal('hide');                               
                            $('#confirmMsg').html("<div class=\"alert alert-success\">User added, please refresh</div>");
                            location.reload();
                        },
                        error:function(msg){
                            $('#myModal').modal('hide');                               
                            $('#errorMsg').html("<div  class=\"alert alert-danger\">Sorry. I cannot add the user!</div>");
                        }
                    });    
                });   
        </script>             
    </body>
</html>
