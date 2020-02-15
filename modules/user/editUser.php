<?php

    include 'class.user.php';

    $uid       = $_POST['uid'];
    $firstName = $_POST['editFirstName'];
    $lastName  = $_POST['editLastName'];
    $userName  = $_POST['editUserName'];
    $password  = $_POST['newPassword'];
    $role      = $_POST['editRole'];

    try{
        $user = new User($uid);        
        $user->editUser($uid, $firstName, $lastName, $userName, $password, $role);
    }catch (Exception $e){
        $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
        echo json_encode($response);               
    }

?>