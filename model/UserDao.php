<?php

require_once 'DbContext.php';
require_once 'user.php';

class UserDao extends DbContext{

    public function GetAll(){
        $conn = $this->connect();
        $result = array();
        $st = $conn->query("SELECT * FROM `users` ORDER BY `users`.`id` ASC");
        while($rs = $st->fetch_assoc()){
            $p = new User($rs['id'],$rs['name'],$rs['lastName'],$rs['years'],$rs['email'],$rs['image'],$rs['documentType'],$rs['numDocument']);
            $result[]=$p;
        }
        $this->close();
        return $result;
    }

    public function GetById($id){
        if ($id) {
            $conn =$this->connect();
            $st = $conn->query("SELECT * FROM users where id = '$id' limit 1");
            while ($rs = $st->fetch_assoc()) {
                return new User($rs['id'],$rs['name'],$rs['lastName'],$rs['years'],$rs['email'],$rs['image'],$rs['documentType'],$rs['numDocument']);
            }
        }
        return null;
    }

    public function store ($user){
        $conn= $this->connect();
        $query = "INSERT INTO `users` (`name`, `lastName`, `years`, `email`, `image`, `documentType`,`numDocument`)
                 values('{$user['name']}','{$user['lastName']}','{$user['years']}','{$user['email']}','{$user['image']}','{$user['documentType']}','{$user['numDocument']}')";
        $st = $conn->query($query);
        $this->close();
        return $st == 1;         
    }

    public function update ($user,$id){
        $conn= $this->connect();
        $query = "UPDATE `users` SET `name`='{$user['name']}', `lastName`='{$user['lastName']}', `years`='{$user['years']}',
                                     `email`='{$user['email']}', `image`='{$user['image']}', `documentType`='{$user['documentType']}',`numDocument`='{$user['numDocument']}' WHERE `users`.`id` = '{$id}'";
        $st = $conn->query($query);
        $this->close();
        return $st == 1;         
    }

    public function delete($id){
        $conn= $this->connect();
        $query = "DELETE FROM `users` WHERE `users`.`id` = '{$id}'";
        $st = $conn->query($query);
        $this->close();
        return $st == 1;
    }


    public function GetByEmail($email){
        if ($email) {
            $conn =$this->connect();
            $st = $conn->query("SELECT * FROM users where email = '$email' limit 1");
            while ($rs = $st->fetch_assoc()) {
                return new User($rs['id'],$rs['name'],$rs['lastName'],$rs['years'],$rs['email'],$rs['image'],$rs['documentType'],$rs['numDocument']);
            }
        }
        return null;
    }

}