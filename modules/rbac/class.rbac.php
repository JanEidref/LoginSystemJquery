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

    }//end of class Login
?>