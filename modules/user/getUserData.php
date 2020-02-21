<?php

    include '../database/database.php';   
    include 'class.user.php';

    $uid = $_POST['id'];
    
    $user = new User();
    echo json_encode($user->getData($uid)); 

?>