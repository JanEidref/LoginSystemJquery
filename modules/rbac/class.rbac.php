<?php

    class Rbac extends Database{

        //Get role of User
        function getUserRole($uid){

            $this->connection->where("uid", $uid);
            $data = $this->connection->getOne("rbac","role");
            return $data['role'];

        }

        //Get role name of User's role
        function getUserRoleName($role){

            $this->connection->where("role_level", $role);
            $data = $this->connection->getOne("roles","role_name");
            return $data['role_name'];

        }
        
        //check all Roles
        function getAllRoles(){

            return $this->connection->get("roles");

        }

        //get max uid in rbac
        function getMaxUidRbac(){

            $data = $this->connection->getValue("rbac", "max(uid)");
            return $data;

        }

        //chechk if role is set
        function checkRole($role){

            if($role == 0){
                throw new Exception("<strong>Error:</strong> Please Select A Role For The User!");
            }

        }

       //add user role
       function addUserRole($role){

            $uid = $this->getMaxUidRbac() + 1;

            $data = array("uid" => $uid, "role" => $role);
            $this->connection->insert('rbac', $data);

       }

       //Delete user role by id
       function deleteUserRole($uid){

            $this->connection->where("uid", $uid); 
            $this->connection->delete("rbac");

       } 

       //Edit user login data
       function editUserRole($uid, $role){

            $data = array('role' => $role);
            $this->connection->where("uid", $uid);
            $this->connection->update("rbac", $data); 

       }

    }//end of class Login
?>