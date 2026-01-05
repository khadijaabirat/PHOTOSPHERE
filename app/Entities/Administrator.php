<?php
require_once __DIR__. '/User.php';
class Administrator extends User {
protected bool $isSuperAdmin;
 
     public function __construct($username,$email,$passworde,$urlphoto=null,$biographie=null,$isSuperAdmin=false)
{ parent::__construct($username,$email,$passworde,$urlphoto,$biographie);
    $this->isSuperAdmin=$isSuperAdmin;
}
public function getisSuperAdmin(){
    return $this->isSuperAdmin=$isSuperAdmin;
}
}

?>