<?php
    
    require_once ('MysqliDb.php');

    class Database{

        public $connection;

        function __construct(){

            $this->connection = new MysqliDb("localhost", "root", "admin", "login");

        }


    }

?>    


