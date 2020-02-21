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
       function checkAddFields($userName, $password, $firstName, $lastName, $role){

            if(!$userName == TRUE || !$password == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }else if($role == 0){
                throw new Exception("<strong>Error:</strong> Please Select A Role For The User!");
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

       //get max uid
       function getMaxUid(){

            $data = $this->connection->getValue("users", "max(uid)");
            return $data;

       }

       //get max uid in user profile
       function getMaxUidProfile(){

            $data = $this->connection->getValue("user_profile", "max(uid)");
            return $data;

        }

        //get max uid in rbac
        function getMaxUidRbac(){

            $data = $this->connection->getValue("rbac", "max(uid)");
            return $data;

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

       //add user role
       function addUserRole($role){

            $uid = $this->getMaxUidRbac() + 1;

            $data = array("uid" => $uid, "role" => $role);
            $this->connection->insert('rbac', $data);

       }

       //Delete user by id
       function deleteUser($uid){

            $name      = $this->getUsersName($uid); 
            $user      = "DELETE FROM users WHERE uid='$uid'";
            $profile   = "DELETE FROM user_profile WHERE uid='$uid'";
            $rbac      = "DELETE FROM rbac WHERE uid='$uid'";

            mysqli_query($this->connection, $user);
            mysqli_query($this->connection, $profile);
            mysqli_query($this->connection, $rbac);

            echo "<strong>Success:</strong> Successfully Deleted User ".$name."!";

       }

    //    //Edit user data
    //    function editUser($uid, $firstName, $lastName, $userName, $password, $role){

    //         if(!$userName == TRUE || !$firstName == TRUE || !$lastName == TRUE){
    //             throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
    //         }else if($role == 0){
    //             throw new Exception("<strong>Error:</strong> Please Select A Role For The User!");
    //         }
            
    //         $query  = $this->connection->prepare("SELECT username FROM users WHERE username=? and uid!=?");
    //         $query  ->bind_param("si", $userName, $uid);
    //         $query  ->execute();
    //         $row    = $query->get_result();

    //         if($row->num_rows > 0){
    //             throw new Exception("<strong>Error:</strong> Username Already Taken!");
    //         }

    //         if(!$password == TRUE){

    //             $editUser    = $this->connection->prepare('UPDATE users SET username=? WHERE uid=?');
    //             $editUser->bind_param("si", $userName, $uid);
    //             $editUser->execute();
    
    //             $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
    //             $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
    //             $editProfile->execute();
    
    //             $editRbac    = $this->connection->prepare('UPDATE rbac SET role=? WHERE uid=?');
    //             $editRbac->bind_param("ii", $role, $uid);
    //             $editRbac->execute();
     
    //             $response    = array('Result' => "<strong>Success:</strong> Successfully Edited User ".$this->getUsersName()."!", 'Status' => "alert alert-success");
    //             echo json_encode($response);

    //         }else{

    //             $encrypt     = password_hash($password, PASSWORD_DEFAULT);

    //             $editUser    = $this->connection->prepare('UPDATE users SET username=?, password=? WHERE uid=?');
    //             $editUser->bind_param("ssi", $userName, $encrypt, $uid);
    //             $editUser->execute();
    
    //             $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
    //             $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
    //             $editProfile->execute();
    
    //             $editRbac    = $this->connection->prepare('UPDATE rbac SET role=? WHERE uid=?');
    //             $editRbac->bind_param("ii", $role, $uid);
    //             $editRbac->execute();
     
    //             $response    = array('Result' => "<strong>Success:</strong> Successfully Edited User ".$this->getUsersName()."!", 'Status' => "alert alert-success");
    //             echo json_encode($response);
                
    //         }

    //    }

    }

?>