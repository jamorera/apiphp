<?php

class DbContext{
    private $conn;
    
    public function connect(){
        $this->conn = null;        
        try{
            $host = 'localhost';
            $db_name = 'crudlaravel';
            $username = 'root';
            $password = '';
            $this->conn= new mysqli($host, $username, $password, $db_name);
        }catch(Exception $e){
            echo "Database could not be connected: " . $e->getMessage();
        }
        return $this->conn;
    }

   public function close(){
       $this->conn = null;
   }

}