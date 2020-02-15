<?php
    class User{

        //Properties of Class User
        private $host     = "localhost";
        private $dbuser   = "root";
        private $dbpass   = "admin";
        private $database = "login";
        private $connection, $uid;
          
        
        //Connect to Database and set id
        function __construct($uid){

            $this->connection = mysqli_connect($this->host, $this->dbuser, $this->dbpass, $this->database);
            $this->uid        = $uid;

            if(!$this->connection){
                die("Error: " .mysqli_error($this->connection));
            }

        }


        //Get role of User
        function getUserRole(){

            $query  = "SELECT role FROM rbac WHERE uid='$this->uid'";
            $result = mysqli_query($this->connection, $query);
            
            if(mysqli_num_rows($result) > 0){

                $data = mysqli_fetch_assoc($result);
                if($data['role'] > 1){
                    return "Guest";
                }else{
                    return "Admin";
                }

            }

        }
        
        //Get name of certain User
        function getUsersName(){

            $query  = "SELECT first_name, last_name FROM user_profile WHERE uid='$this->uid'";
            $result = mysqli_query($this->connection, $query);
            
            if(mysqli_num_rows($result) > 0){
                
                $data = mysqli_fetch_assoc($result);

                return $data['first_name']." ".$data['last_name'];

            }

        }

        //Get all users
        function getAllFromUser(){

            $query     = "SELECT * FROM users";
            $result    = mysqli_query($this->connection, $query);
            $resultSet = array();
            
            if(mysqli_num_rows($result) > 0){

                while($data = mysqli_fetch_assoc($result)){

                    array_push($resultSet, $data);    

                }

                return $resultSet;

            }

       }

       //get data of certain user
       function getData(){

            $query     = "SELECT * FROM complete_data where uid='$this->uid'";
            $result    = mysqli_query($this->connection, $query);

            if(mysqli_num_rows($result) > 0){

                while($data = mysqli_fetch_assoc($result)){

                    $resultSet = array('Uid'      => $data['uid'],       'UserName' => $data['username'], 'FirstName' => $data['first_name'], 
                                       'LastName' => $data['last_name'], 'Role'     => $data['role']);     

                }

                echo json_encode($resultSet);

            }

       }

       //Validate form input and add user if input is valid
       function addUser($userName, $password, $firstName, $lastName, $role){

            if(!$userName == TRUE || !$password == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }else if($role == 0){
                throw new Exception("<strong>Error:</strong> Please Select A Role For The User!");
            }

            $query             = "SELECT username FROM users WHERE username='$userName'";
            $result            = mysqli_query($this->connection, $query);

            if(mysqli_num_rows($result) > 0){
                throw new Exception("<strong>Error:</strong> Username Already Taken!");
            }

            $selectUsers       = "SELECT uid FROM users";
            $selectUsersResult = mysqli_query($this->connection, $selectUsers);
            $uid               = 0;

            if(mysqli_num_rows($selectUsersResult) > 0){

                while($data = mysqli_fetch_assoc($selectUsersResult)){

                    if($data['uid'] > $uid){

                        $uid = $data['uid'];

                    }   

                }

                $uid = $uid + 1;

            }

            $encrypt = password_hash($password, PASSWORD_DEFAULT);
        
            $user    = $this->connection->prepare("INSERT into users (uid,username,password) VALUES (?,?,?)");
            $user->bind_param("iss",$uid,$userName,$encrypt);
            $user->execute();

            $profile = $this->connection->prepare("INSERT into user_profile (uid,first_name,last_name) VALUES (?,?,?)");
            $profile->bind_param("iss",$uid,$firstName,$lastName);
            $profile->execute();

            $rbac    = $this->connection->prepare("INSERT into rbac (uid,role) VALUES (?,?)");
            $rbac->bind_param("ii",$uid,$role);
            $rbac->execute();

            $response = array('Result' => "<strong>Success:</strong> Successfully Added User!", 'Status' => "alert alert-success");
            echo json_encode($response);

       }

       //Delete user by id
       function deleteUser(){

            $name      = $this->getUsersName(); 
            $user      = "DELETE FROM users WHERE uid='$this->uid'";
            $profile   = "DELETE FROM user_profile WHERE uid='$this->uid'";
            $rbac      = "DELETE FROM rbac WHERE uid='$this->uid'";

            mysqli_query($this->connection, $user);
            mysqli_query($this->connection, $profile);
            mysqli_query($this->connection, $rbac);

            echo "<strong>Success:</strong> Successfully Deleted User ".$name."!";

       }

       //Edit user data
       function editUser($uid, $firstName, $lastName, $userName, $password, $role){

            if(!$userName == TRUE || !$firstName == TRUE || !$lastName == TRUE){
                throw new Exception("<strong>Error:</strong> No Blank Fields Please!");
            }else if($role == 0){
                throw new Exception("<strong>Error:</strong> Please Select A Role For The User!");
            }
            
            $query  = "SELECT username FROM users WHERE username='$userName' and uid!='$uid'";
            $result = mysqli_query($this->connection, $query);

            if(mysqli_num_rows($result) > 0){
                throw new Exception("<strong>Error:</strong> Username Already Taken!");
            }

            if(!$password == TRUE){

                $editUser    = $this->connection->prepare('UPDATE users SET username=? WHERE uid=?');
                $editUser->bind_param("si", $userName, $uid);
                $editUser->execute();
    
                $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
                $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
                $editProfile->execute();
    
                $editRbac    = $this->connection->prepare('UPDATE rbac SET role=? WHERE uid=?');
                $editRbac->bind_param("ii", $role, $uid);
                $editRbac->execute();
     
                $response    = array('Result' => "<strong>Success:</strong> Successfully Edited User ".$this->getUsersName()."!", 'Status' => "alert alert-success");
                echo json_encode($response);

            }else{

                $encrypt     = password_hash($password, PASSWORD_DEFAULT);

                $editUser    = $this->connection->prepare('UPDATE users SET username=?, password=? WHERE uid=?');
                $editUser->bind_param("ssi", $userName, $encrypt, $uid);
                $editUser->execute();
    
                $editProfile = $this->connection->prepare('UPDATE user_profile SET first_name=?, last_name=? WHERE uid=?');
                $editProfile->bind_param("ssi", $firstName, $lastName, $uid);
                $editProfile->execute();
    
                $editRbac    = $this->connection->prepare('UPDATE rbac SET role=? WHERE uid=?');
                $editRbac->bind_param("ii", $role, $uid);
                $editRbac->execute();
     
                $response    = array('Result' => "<strong>Success:</strong> Successfully Edited User ".$this->getUsersName()."!", 'Status' => "alert alert-success");
                echo json_encode($response);
                
            }

       }

    }

?>