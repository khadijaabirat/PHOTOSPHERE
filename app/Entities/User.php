<?php 
abstract class user{
protected int $id_user;
protected string $username;
protected string $email;
protected string $password;
protected datetime $createAt;
protected ?datetime $lastLoging;
protected ?string $urlPhoto=null;
protected ?string $biographie=null;

public function __constract($username,$email,$password,$createAt,$urlPhoto,$biographie)
{
    $this->username=$username;
    $this->email=$email;
    $this->password=$password;
    $this->createAt=new datetime();
    $this->urlPhoto=$urlPhoto;
    $this->biographie=$biographie;
}

}


?>