<?php

    class User extends Database{   
        
        //get user id by username
        function getUId($userName){

            $this->connection->where("username", $userName);
            $data = $this->connection->getOne("users");
            return $data['uid'];

        }

        //Get name of certain User
        function getUsersName($uid){

            $this->connection->where("uid", $uid);
            $data = $this->connection->getOne("user_profile");
            return $data['first_name']." ".$data['last_name'];   

        }

        //Get all users
        function getAllFromUser(){

            return $this->connection->get("users");

       }

       //get data of certain user
       function getData($uid){

            $this->connection->where("uid", $uid);
            return $this->connection->getOne("complete_data");

       }

       //validate add fields
       function checkAddFields($userName, $password, $firstName, $lastName){

            if(!$userName == TRUE || !$password == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }

       }

       //validate edit fields
       function checkEditFields($userName, $firstName, $lastName){

            if(!$userName == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }

       }



       //check if username is already taken
       function checkUserName($userName){

            $this->connection->where("username", $userName);
            $row = $this->connection->getOne("users");

            if(!is_null($row)){
                throw new Exception("<strong>Error:</strong> Username Already Taken!");
            }

       }

       //check if username is taken on edit
       function checkUserEditName($uid, $userName){

          $this->connection->where("username", $userName);
          $this->connection->where("uid != ".$uid);
          $row = $this->connection->getOne("users");

          if(!is_null($row)){
              throw new Exception("<strong>Error:</strong> Username Already Taken!");
          }

     }
       //get max uid
       function getMaxUid(){

           return $this->connection->getValue("users", "max(uid)");

       }

       //get max uid in user profile
       function getMaxUidProfile(){

            return $this->connection->getValue("user_profile", "max(uid)");

       }

       //add user login info
       function addUser($userName, $password){

            $uid     = $this->getMaxUid() + 1;
            $encrypt = password_hash($password, PASSWORD_DEFAULT);

            $data = array("uid" => $uid, "username" => $userName, "password" => $encrypt);
            $this->connection->insert('users', $data);

       }

       //add user profile
       function addUserProfile($firstName, $lastName){

            $uid = $this->getMaxUidProfile() + 1;

            $data = array("uid" => $uid, "first_name" => $firstName, "last_name" => $lastName);
            $this->connection->insert('user_profile', $data);

       }

       //Delete user login data by id
       function deleteUser($uid){

            $this->connection->where("uid", $uid); 
            $this->connection->delete("users");

       }

       //Delete user profile by id
       function deleteUserProfile($uid){

          $this->connection->where("uid", $uid); 
          $this->connection->delete("user_profile");

       }

       //Edit user login data
       function editUser($uid, $userName, $password){

            if(!$password == TRUE){

               $data = array('username' => $userName);
               $this->connection->where("uid", $uid);
               $this->connection->update("users", $data);               

            }else{

                $encrypt = password_hash($password, PASSWORD_DEFAULT);

                $data = array('username' => $userName, 'password' => $encrypt);
                $this->connection->where("uid", $uid);
                $this->connection->update("users", $data);
                
            }

       }

       //Edit user login data
       function editUserProfile($uid, $firstName, $lastName){

          $data = array('first_name' => $firstName, 'last_name' => $lastName);
          $this->connection->where("uid", $uid);
          $this->connection->update("user_profile", $data); 

       }

    }

?>