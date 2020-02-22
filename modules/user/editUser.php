<?php

    require_once '../database/database.php';
    include '../rbac/class.rbac.php';
    include 'class.user.php';

    $uid       = $_POST['uid'];
    $firstName = $_POST['editFirstName'];
    $lastName  = $_POST['editLastName'];
    $userName  = $_POST['editUserName'];
    $password  = $_POST['newPassword'];
    $role      = $_POST['editRole'];

    try{
        $user = new User();        
        $rbac = new Rbac();  
        $name = $user->getUsersName($uid);      
        $user->checkEditFields($userName, $firstName, $lastName);
        $user->checkUserEditName($uid, $userName);
        $rbac->checkRole($role);
        $user->editUser($uid, $userName, $password);
        $user->editUserProfile($uid, $firstName, $lastName);
        $rbac->editUserRole($uid, $role);
        $response = array('Result' => "<strong>Success:</strong> Successfully Edited User ".$name."!", 'Status' => "alert alert-success");
        echo json_encode($response);
    }catch (Exception $e){
        $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
        echo json_encode($response);               
    }

?>