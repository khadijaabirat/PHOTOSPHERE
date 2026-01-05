<?php
require_once __DIR__.'/User.php';
class Moderator extends User {
    protected string $level;

    public function __construct($username,$email,$passworde,$urlphoto=null,$biographie=null,$level='junior')
{ parent::__construct($username,$email,$passworde,$urlphoto,$biographie);
  return $this->level=$level;
}
public function getlevel(){
   return  $this->leve=$level;
}
}

?>