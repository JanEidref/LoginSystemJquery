<?php

    include 'class.login.php';

    $userName = $_POST['userName'];
    $password = $_POST['password'];

    $login = new Login();
    $login -> checkLogin($userName, $password);

?>