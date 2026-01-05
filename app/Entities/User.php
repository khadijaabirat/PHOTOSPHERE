<?php 
abstract class User{
protected int $id_user;
protected string $username;
protected string $email;
protected string $passworde;
protected DateTime $createAt;
protected ?DateTime $lastLogin;
protected ?string $urlphoto=null;
protected ?string $biographie=null;

public function __construct($username,$email,$passworde,$urlphoto=null,$biographie=null)
{  
    $this->username=$username;
    $this->email=$email;
    $this->passworde=$passworde;
    $this->createAt=new DateTime();
    $this->urlphoto = $urlphoto;
    $this->biographie=$biographie;
}
public function getid(){
return $this->id_user;
}
public function setid(int $id){
    $this->id_user=$id;
}
public function getusername(){
return $this->username;
}
public function getemail(){
return $this->email;
}
public function getpassworde(){
return $this->passworde;
}
public function geturlphoto(){
return $this->urlphoto;
}
public function getbiographie(){
return $this->biographie;
}
    

}


?>