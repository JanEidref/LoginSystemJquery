<?php

    session_start();
    include '../database/database.php';
    include '../rbac/class.rbac.php';
    include '../user/class.user.php';
    include 'class.login.php';

    $userName = $_POST['userName'];
    $password = $_POST['password'];

    $login    = new Login();
    $rbac     = new Rbac();
    $user     = new User();
    $result   = $login -> checkLogin($userName, $password);
    $id       = $user->getUId($userName);
    $name     = $user->getUsersName($id);
    $role     = $rbac->getUserRole($id);
    $roleName = $rbac->getUserRoleName($role);

    switch($result){

        case 1:
            $_SESSION['uid']       = $id;
            $_SESSION['name']      = $name;
            $_SESSION['role']      = $role;
            $_SESSION['roleName']  = $roleName;
            header('Location: ../../main.php');
        break;
        
        case 2:
            $_SESSION['Error'] = "Wrong Password!";
            header('Location: ../../index.php');
        break;

        case 3:
            $_SESSION['Error'] = "No Such User!";
            header('Location: ../../index.php');
        break;

    }

?>