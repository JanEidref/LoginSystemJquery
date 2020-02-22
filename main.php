<?php
    session_start();
    require_once 'modules/database/database.php';
    include      'modules/user/class.user.php';
    include      'modules/rbac/class.rbac.php';

    $id       = $_SESSION['uid'];
    $name     = $_SESSION['name'];
    $role     = $_SESSION['role'];
    $roleName = $_SESSION['roleName'];
    

    if(!$id){
        $_SESSION['Error'] = "Access Denied!";
        header('Location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link   rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Main Page</title>
</head>
<body>
    <div class="container">
        <h1 class="text-info font-weight-bolder text-center">
            <?php 
                echo 'Hello, '.$roleName.' '.$name.'! ';
                echo '<a class="text-danger" href="modules/login/logout.php" data-toggle="tooltip" data-placement="right" title="Logout!">x</a>';
            ?>
        </h1>
        <nav class="mb-4">            
                <?php
                    if($role == 1){
                        echo '<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">';
                        echo '<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>';
                        echo '<a class="nav-item nav-link" id="nav-add-tab" data-toggle="tab" href="#nav-add" role="tab" aria-controls="nav-add" aria-selected="false">Add</a>';
                        echo '<a class="nav-item nav-link" id="nav-edit-tab" data-toggle="tab" href="#nav-edit" role="tab" aria-controls="nav-edit" aria-selected="false">Edit</a>';
                        echo '<a class="nav-item nav-link" id="nav-delete-tab" data-toggle="tab" href="#nav-delete" role="tab" aria-controls="nav-delete" aria-selected="false">Delete</a>';
                        echo '</div>';
                    }else{
                        echo '<h3 class="text-center">Home</h3>';
                        echo '<hr>';
                    }                
                ?>           
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <h5 class="text-info text-center">All Users</h5>
               <?php
                    include 'modules/resources/dataTable.php';
               ?>
            </div>
            <div class="tab-pane fade" id="nav-add" role="tabpanel" aria-labelledby="nav-edit-tab">
                <h5 class="text-success text-center">User Data</h5> 
                <form method="POST" id="addUserForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="" id="addStatus">

                            </div>  
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Username</span>
                        </div>
                        <input type="text" id="userName" class="form-control" name="userName" autocomplete="off">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Password</span>
                        </div>
                        <input type="password" id="password" class="form-control" name="password" autocomplete="off">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Name</span>
                        </div>
                        <input type="text" id="firstName" class="form-control" name="firstName"  placeholder="First Name"  autocomplete="off">
                        <input type="text" id="lastName" class="form-control" name="lastName" placeholder="Last Name" autocomplete="off">
                    </div>
                    <div class="row">
                        <div id="selectAdd" class="col-sm-6">
                            <select class="browser-default custom-select" name="role">
                                <option value="0" selected>--User Roles--</option>
                                <?php
                                    include 'modules/resources/roleSelect.php';
                                ?>
                            </select> 
                        </div>
                        <div class="col-sm-6">
                            <input type="submit" class="btn btn-block btn-success" id="submit" name="submit" value="Add">
                        </div>                        
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="nav-edit" role="tabpanel" aria-labelledby="nav-edit-tab">
                <div id="edit">
                    <h5 class="text-primary text-center">Select User To Edit</h5>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="" id="editStatus">

                            </div>  
                        </div>
                    </div>
                    <?php
                        include 'modules/resources/editTable.php';
                    ?>
                </div>

                <form method="POST" id="editUserForm">
                    <h5 id="editName" class="text-primary text-center"></h5>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="" id="editStatus">

                            </div>  
                        </div>
                    </div>
                    <input type="text" id="uid" name="uid" hidden>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Name</span>
                        </div>
                        <input type="text" id="editFirstName" class="form-control" name="editFirstName"  placeholder="First Name"  autocomplete="off">
                        <input type="text" id="editLastName" class="form-control" name="editLastName" placeholder="Last Name" autocomplete="off">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Username</span>
                        </div>
                        <input type="text" id="editUserName" class="form-control" name="editUserName" autocomplete="off">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Password</span>
                        </div>
                        <input type="password" id="editPassword" class="form-control" name="newPassword" placeholder="Input only if you want to change password!" autocomplete="off">
                    </div>
                    <div class="row">
                        <div id="selectEdit" class="col-sm-6">
                            <select class="browser-default custom-select" name="editRole">
                                <option value="0">--User Roles--</option>
                                <?php
                                    include 'modules/resources/editRoleSelect.php';
                                ?>
                            </select> 
                        </div>
                        <div class="col-sm-6">
                            <input type="submit" class="btn btn-block btn-primary" id="editSubmit" name="editSubmit" value="Edit">
                        </div>        
                    </div>
                </form>

                <div id="undo" class="mt-2"><button class="undo btn btn block btn-danger" name="undo">Back</button></div>
            </div>
            <div class="tab-pane fade" id="nav-delete" role="tabpanel" aria-labelledby="nav-delete-tab">
                <h5 class="text-danger text-center">Select User To Delete</h5>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="" id="deleteStatus">

                        </div>  
                    </div>
                </div>
                <?php
                    include 'modules/resources/deleteTable.php';
               ?>
            </div>
        </div> 
    </div>   
</body>
<script>
    $(document).ready(function(){

        $('[data-toggle="tooltip"]').tooltip();
        $("#editUserForm")          .hide();
        $("#undo")                  .hide();

        //add user function
        $('#addUserForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                type    : "POST",
                url     : 'modules/user/addUser.php',
                data    : $(this).serialize(),
                success : function(response){
                    var jsonData = JSON.parse(response);
                    $('#addStatus')       .html(jsonData.Result);
                    $('#addStatus')       .attr("class", jsonData.Status);
                    $("#dataTable")       .load(location.href+" #dataTable>*","");
                    $("#tableDelete")     .load(location.href+" #tableDelete>*","");
                    $("#tableEdit")       .load(location.href+" #tableEdit>*","");
                    $('#userName')        .val("");
                    $('#password')        .val("");
                    $('#firstName')       .val("");
                    $('#lastName')        .val("");
                    $('#selectAdd select').val (0);
                    $('#deleteStatus')    .html("");
                    $('#deleteStatus')    .attr("class", "");
                    $('#editStatus')      .html("");
                    $('#editStatus')      .attr("class", "");
                }
            });
        });

        //delete user function
        $(document).on("click", ".delete", function(){
            if (confirm("Are you sure?")) {
                $.ajax({
                    type     : "POST",
                    url      : 'modules/user/deleteUser.php',
                    data     : {id:$(this).val()},
                    success  : function(response){
                        $('#deleteStatus').html(response);
                        $('#deleteStatus').attr("class", "alert alert-success");
                        $('#addStatus')   .html("");
                        $('#addStatus')   .attr("class", "");
                        $('#editStatus')  .html("");
                        $('#editStatus')  .attr("class", "");
                        $("#dataTable")   .load(location.href+" #dataTable>*","");
                        $("#tableDelete") .load(location.href+" #tableDelete>*","");
                        $("#tableEdit")   .load(location.href+" #tableEdit>*","");
                    }
                });
            }
            return false;

        });

        //show data of user to be edit
        $(document).on("click", ".edit", function(){
            $.ajax({
                type     : "POST",
                url      : 'modules/user/getUserData.php',
                data     : {id:$(this).val()},
                success  : function(response){
                    var jsonData  = JSON.parse(response);
                    var space     = " ";
                    var firstName = jsonData.first_name.concat(space);
                    var fullName  = firstName.concat(jsonData.last_name)
                    $('#editName')         .html(fullName);
                    $('#editFirstName')    .attr("placeholder", jsonData.first_name);
                    $('#editLastName')     .attr("placeholder", jsonData.last_name);
                    $('#editUserName')     .attr("placeholder", jsonData.username);
                    $('#uid')              .attr("value", jsonData.uid);
                    $('#selectEdit select').val (jsonData.role);
                    $('#addStatus')        .html("");
                    $('#addStatus')        .attr("class", "");
                    $('#deleteStatus')     .html("");
                    $('#deleteStatus')     .html("class", "");
                    $('#editUserForm')     .show();
                    $('#edit')             .hide();
                    $('#undo')             .show();
                }
            });
        });

        //undo select of edit
        $(document).on("click", ".undo", function(){
            $('#editUserForm')     .hide();
            $('#edit')             .show();
            $('#undo')             .hide();
            $('#editUserName')     .val("");
            $('#editPassword')     .val("");
            $('#editFirstName')    .val("");
            $('#editLastName')     .val("");
            $('#selectEdit select').val(0);
        });

        //edit user function
        $('#editUserForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                type    : "POST",
                url     : 'modules/user/editUser.php',
                data    : $(this).serialize(),
                success : function(response){
                    var jsonData = JSON.parse(response);
                    $('#editStatus')       .html(jsonData.Result);
                    $('#editStatus')       .attr("class", jsonData.Status);
                    $("#dataTable")        .load(location.href+" #dataTable>*","");
                    $("#tableDelete")      .load(location.href+" #tableDelete>*","");
                    $("#tableEdit")        .load(location.href+" #tableEdit>*","");
                    $('#editUserName')     .val("");
                    $('#editPassword')     .val("");
                    $('#editFirstName')    .val("");
                    $('#editLastName')     .val("");
                    $('#selectEdit select').val(0);
                    $('#deleteStatus')     .html("");
                    $('#deleteStatus')     .attr("class", "");
                    $('#addStatus')        .html("");
                    $('#addStatus')        .attr("class", "");
                    $('#editUserForm')     .hide();
                    $('#edit')             .show();
                    $('#undo')             .hide();
                }
            });
        });

    });
</script>
</html>