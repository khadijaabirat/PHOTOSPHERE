<?php

trait TimestampableTrait{
protected DateTimeInterface $createdAt;
protected ?DateTimeInterface $updatedAt=null;

public function initializeTimestamps():void{
 $this->createdAt=new DateTime();
 $this->updatedAt=null;
}
public function updateTimestamps():void{
    $this->updatedAt=new DateTime();
}

public function getcreatedAt(){
   return $this->createdAt;
}
public function getupdatedAt(){
   return $this->updatedAt;
}
}