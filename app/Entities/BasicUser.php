<?php
require_once __DIR__.'/User.php';
class BasicUser extends User{
protected int $uploadCount=0;
protected ?int $limit=10;

public function __construct($username,$email,$passworde,$urlphoto=null,$biographie=null,$uploadCount=0)
{ 
    parent::__construct($username,$email,$passworde,$urlphoto,$biographie);
    $this->uploadCount=$uploadCount;
}

public function getuploadCount(){
    return $this->uploadCount;
}



}
?>