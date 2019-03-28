<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ums</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
                
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

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
                   List of groups
                </div>
                
                <div id="errorMsg"></div>
                <div id="confirmMsg"></div>
                @if (session('isadmin'))     
                    <div>                        
                        Click the Icon <i class="fas fa-users"></i> o modify the group
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add group</button>          
                    </div>    
                    <table class="table table-hover"> 
                        <thead>                            
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>                                
                                <th scope="col">Users</th>
                                <th scope="col">Operations</th>
                            </tr>
                        </thead>              
                        <tbody>                            
                        @foreach (App\Group::all() as $group)
                            <tr id="row_{{ $group->id }}">
                                <th scope="row">{{ $group->id }}</th>
                                <td align="left">{{ $group->name }}</td>                                
                                <td align="left">{{ $group->userConnected() }}</td>                                
                                <td align="left">
                                    <a style="cursor:pointer" data-id="{{ $group->id }}" data-name="{{ $group->name }}" class="modify" title="Modify users" target="_blank" >
                                            <i class="fas fa-users fa-2x"></i>
                                    </a>
                                    @if (!$group->userConnected())
                                    <a style="cursor:pointer" data-id="{{ $group->id }}" class="delete" title="Delete group">
                                        <i class="fa fa-trash fa-2x"></i>
                                    </a>
                                    @endif                                                                        
                                </td>
                            </tr>                                                
                        @endforeach             
                        </tbody>
                    </table>
                @endif
                
            </div>
        </div>

        <!-- Modal add group -->        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Add group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">                        
                        <input type="text" id="form_name" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="form_name">Name</label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-success" id="addButton">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal add user-->      
        <div class="modal fade" id="myModalChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Add group</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="md-form mb-5">  
                            <input type="hidden" id="form_id_user">                      
                            <input type="text" id="form_name_user" class="form-control validate">
                            <label data-error="wrong" data-success="right" for="form_name_user">Name</label>
                        </div>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="md-form mb-5">                       
                            <select class="selectpicker form-control validate" multiple data-live-search="true" id="form_user">                                
                            </select>
                            <label data-error="wrong" data-success="right" for="form_user">User</label>                          
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button class="btn btn-success" id="addButtonUsers">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
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
                        url: "group/delete/"+id,
                        type: 'DELETE',
                        dataType: "JSON",
                        data: {
                            "id": id,
                            "_method": 'DELETE',                            
                        },
                        success: function ()
                        {                            
                            $('#row_' + id).remove();
                            $('#confirmMsg').html("<div class=\"alert alert-success\">Group deleted</div>");
                        },
                        error:function(msg){
                            $('#errorMsg').html("<div  class=\"alert alert-danger\">Sorry. I cannot delete the group!</div>");
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
                        url: "group/add",
                        type: 'POST',
                        dataType: "JSON",
                        data: {
                            "name": $('#form_name').val(),                            
                        },
                        success: function ()
                        {                         
                            $('#myModal').modal('hide');                               
                            $('#confirmMsg').html("<div class=\"alert alert-success\">Group added</div>");
                            location.reload();
                        },
                        error:function(msg){
                            $('#myModal').modal('hide');                               
                            $('#errorMsg').html("<div  class=\"alert alert-danger\">Sorry. I cannot add the group!</div>");
                        }
                    });    
                });   


                $("#addButtonUsers").click(function(){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax(
                    {
                        url: "group/" + $('#form_id_user').val(),
                        type: 'PUT',
                        dataType: "JSON",
                        data: {
                            "id": $('#form_id_user').val(),
                            "name": $('#form_name_user').val(),   
                            "users": $('#form_user').val(),                            
                        },
                        success: function ()
                        {                         
                            $('#myModal').modal('hide');                               
                            $('#confirmMsg').html("<div class=\"alert alert-success\">Group changed</div>");
                            location.reload();
                        },
                        error:function(msg){
                            $('#myModal').modal('hide');                               
                            $('#errorMsg').html("<div  class=\"alert alert-danger\">Sorry. I cannot change the group!</div>");
                        }
                    });    
                });   

                $(".modify").click(function(){
                    var id = $(this).data("id");   
                    var name = $(this).data("name"); 
                    $('#form_id_user').val(id);
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax(
                    {
                        url: "group/users",
                        type: 'get',
                        dataType: "JSON",
                        data: {
                            "id": id
                        },
                        success: function (data)
                        {              
                            $('#form_name_user').val(name);              
                            $('#form_user').find('option').remove();                                                     
                            $('#myModalChange').modal('show');       
                            var elenco = [];                 
                            var selectedAttr = "";     
                            $.each(data, function(i, d) {                                    
                                if (d.group_id == id) {
                                    selectedAttr = "selected";
                                    elenco.push(d.id);
                                    $('#form_user').append('<option ' + selectedAttr + ' value="' + d.id + '">' + d.name + '</option>');
                                }                                                 
                            });
                            $.each(data, function(i, d) {                                      
                                if ((d.group_id != id) && (elenco.includes(d.id) === false)) {                                    
                                    elenco.push(d.id);
                                    $('#form_user').append('<option  value="' + d.id + '">' + d.name + '</option>');
                                }                                                 
                            });     
                            $('#form_user').selectpicker('refresh');                  
                        },
                        error:function(msg){
                            $('#errorMsg').html("<div  class=\"alert alert-danger\">Sorry. I cannot delete the group!</div>");
                        }
                    });                    
                });  
        </script>             
    </body>
</html>
