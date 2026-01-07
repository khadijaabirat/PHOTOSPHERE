<?php 

abstract class User{
protected ?int $id_user=null;
protected string $username;
protected string $email;
protected string $passworde;
protected DateTime  $createAt;
protected ?DateTime  $lastLogin=null;
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
public function getid():?int{
return $this->id_user;
}
public function setId(int $id):void{
    $this->id_user=$id;
}
public function getusername():string{
return $this->username;
}
public function setusername($username):void{
return $this->username=$username;
}
public function getemail():string{
return $this->email;
}
public function getpassworde():string{
return $this->passworde;
}
public function getcreateAt(): DateTime {
return $this->createAt;
}
public function getlastLogin(): ?DateTime {
return $this->lastLogin;
}
   public function setLastLogin(?DateTime $lastLogin): void {
        $this->lastLogin = $lastLogin;
    }
public function geturlphoto():?string{
return $this->urlphoto;
}
public function getbiographie():?string{
return $this->biographie;
}
  
    public function affichage()
    {
        return "ID:{$this->id_user} <br>username: {$this->username}<br>email: ({$this->email})<br>";
    }
 

}


?>