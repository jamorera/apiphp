<?php

class Role {
    public  int $id;
    public  string $title;

    public function __construct($id,$title)
    {
        $this->id =$id;
        $this->title = $title;
    }

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

}