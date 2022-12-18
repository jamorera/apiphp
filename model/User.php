<?php

class User {
    private  int $id;
    private  string $name;
    private  string $lastName;
    private  int $years;
    private  string $email;
    private  string $image;
    private  string $documentType;
    // private $numDocument;

    public function __construct($id,$name,$lastName,$years,$email,$image,$documentType)
    {
        $this->id =$id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->years = $years;
        $this->email = $email;
        $this->image = $image;
        $this->documentType = $documentType;
        // $this->numDocument = $numDocument;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getYears(){
        return $this->years;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getImage(){
        return $this->image;
    }

    public function getDocumentType(){
        return $this->documentType;
    }

    // public function getNumDocument(){
    //     return $this->numDocument;
    // }

}