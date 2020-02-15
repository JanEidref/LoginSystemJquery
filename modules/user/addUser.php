<?php

    include 'class.user.php';

    $userName  = $_POST['userName'];
    $password  = $_POST['password']; 
    $firstName = $_POST['firstName']; 
    $lastName  = $_POST['lastName']; 
    $role      = $_POST['role']; 

    try{
        $user = new User(1);
        $user->addUSer($userName, $password, $firstName, $lastName, $role);        
    }catch (Exception $e){
        $response = array('Result' => $e->getMessage(), 'Status' => "alert alert-danger");
        echo json_encode($response);
    }

?>