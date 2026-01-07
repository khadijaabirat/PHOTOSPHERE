
<?php
class Taguee{
    private ?int $id_t;
    private int $id_photo;
    private int $id_tag;
	private DateTime $createdAt;
    public function __construct($id_photo,$id_tag)
    {
       $this->id_photo=$id_photo;
       $this->id_tag=$id_tag;
       $this->createdAt= new DateTime();
    }
        public function getId(): ?int
         { 
            return $this->id_t; 
        }

        public function getid_photo(){
        return $this->id_photo;
    }
    public function getid_tag(){
        return $this->id_tag;
    }
        public function getcreatedAt(){
        return $this->createdAt;
    }
}