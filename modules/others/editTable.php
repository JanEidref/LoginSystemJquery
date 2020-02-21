<?php

    $uid = $_SESSION['uid'];

    if(!$uid){

        session_start();
        $_SESSION['Error'] = "Access Denied!";
        header('Location: ../../index.php');
        exit();       

    }

    echo '<table id="tableEdit" class="table table-hover table-bordered mt-2">';
    echo '  <thead>';
    echo '      <tr>';
    echo '          <th class="text-center"></th>';
    echo '          <th class="text-center">Username</th>';
    echo '          <th class="text-center">Name</th>';
    echo '          <th class="text-center">Role</th>';
    echo '          <th class="text-center">Action</th>';
    echo '      </tr>';
    echo '  </thead>';
    echo '  <tbody>';

    $number = 1;
    $user = new User();
    $rbac = new Rbac();

    foreach($user->getAllFromUser() as $data){

        if($uid <> $data['uid']){

            $roleName = $rbac->getUserRoleName($rbac->getUserRole($data['uid']));

            echo '  <tr>';
            echo '      <td class="text-center">'.$number.'</td>';
            echo '      <td class="text-center">'.$data['username'].'</td>';
            echo '      <td class="text-center">'.$user->getUsersName($data['uid']).'</td>';
            echo '      <td class="text-center">'.$roleName.'</td>';
            echo '      <td class="text-center"><button class="edit btn btn-primary" value="'.$data['uid'].'" name="edit">Edit</button></td>';
            echo '  </tr>';

            $number++;

        }

    }

    echo '  </tbody>';
    echo '</table>';

?>