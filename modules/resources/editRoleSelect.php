<?php

    $uid = $_SESSION['uid'];

    if(!$uid){

        session_start();
        $_SESSION['Error'] = "Access Denied!";
        header('Location: ../../index.php');
        exit();        

    }

    $rbac = new Rbac();

    foreach($rbac->getAllRoles() as $data){

        if($rbac->getUserRole($uid) == $data['role_level']){

            echo '<option value="'.$data['role_level'].'" selected>'.$data['role_name'].'</option>';

        }else{

            echo '<option value="'.$data['role_level'].'">'.$data['role_name'].'</option>';

        }

    }


?>