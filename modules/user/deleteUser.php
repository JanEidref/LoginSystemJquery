<?php

    require_once '../database/database.php';
    include '../rbac/class.rbac.php';
    include 'class.user.php';

    $uid = $_POST['id'];

    $user = new User();       
    $rbac = new Rbac();
    $name = $user->getUsersName($uid);       
    $user->deleteUser($uid);
    $user->deleteUserProfile($uid);
    $rbac->deleteUserRole($uid);
    echo "<strong>Success:</strong> Successfully Deleted User ".$name."!";

?>