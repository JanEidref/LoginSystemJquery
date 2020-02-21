<?php

    require_once '../database/database.php';
    include 'class.user.php';

    $userName  = $_POST['userName'];
    $password  = $_POST['password']; 
    $firstName = $_POST['firstName']; 
    $lastName  = $_POST['lastName']; 
    $role      = $_POST['role']; 

    try{
        $user = new User();
        $user->checkAddFields($userName, $password, $firstName, $lastName, $role);
        $user->checkUserName($userName);        
        $user->addUser($userName, $password);
        $user->addUserProfile($firstName, $lastName);
        $user->addUSerRole($role);
        $response = array('Result' => "<strong>Success:</strong> Successfully Added User!", 'Status' => "alert alert-success");
        echo json_encode($response);        
    }catch (Exception $e){
        $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
        echo json_encode($response);
    }

?>