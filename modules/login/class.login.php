<?php

    class Login extends Database{

        function checkLogin($userName, $password){

            $this  ->connection->where ("username", $userName);
            $row   = $this->connection->getOne("users");            
            $hash  = $row['password'];

            if(!is_null($row)){

                if(password_verify($password, $hash)){

                    return 1;
                    
                }else{

                    return 2;

                }

            }else{

                return 3;
                
            }

        }

    }//end of class Login
?>