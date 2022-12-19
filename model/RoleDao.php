<?php

require_once 'DbContext.php';
require_once 'role.php';

class RoleDao extends DbContext{

    public function GetAll(){
        $conn = $this->connect();
        $result = array();
        $st = $conn->query("SELECT * FROM `roles` ORDER BY `roles`.`id` ASC");
        while($rs = $st->fetch_assoc()){
            $p = new Role($rs['id'],$rs['title']);
            $result[]=$p;
        }
        $this->close();
        return $result;
    }

    public function GetById($id){
        if ($id) {
            $conn =$this->connect();
            $st = $conn->query("SELECT * FROM roles where id = '$id' limit 1");
            while ($rs = $st->fetch_assoc()) {
                return new Role($rs['id'],$rs['title']);
            }
        }
        return null;
    }

    public function store ($user){
        $conn= $this->connect();
        $query = "INSERT INTO `roles` (`title`) values('{$user['title']}')";
        $st = $conn->query($query);
        $this->close();
        return $st == 1;         
    }

    public function update ($user,$id){
        $conn= $this->connect();
        $query = "UPDATE `roles` SET `title`='{$user['title']}' WHERE `roles`.`id` = '{$id}'";
        $st = $conn->query($query);
        $this->close();
        return $st == 1;         
    }

    public function delete($id){
        $conn= $this->connect();
        $query = "DELETE FROM `roles` WHERE `roles`.`id` = '{$id}'";
        $st = $conn->query($query);
        $this->close();
        return $st == 1;
    }

}