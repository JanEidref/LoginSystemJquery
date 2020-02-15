<?php

    include 'class.user.php';

    $uid = $_POST['id'];
    
    $user = new User($uid);
    $user->getData(); 

?>