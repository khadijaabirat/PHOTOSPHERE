<?php
class photo {
   private int $id_photo;
   private string $titre ;
   private string $description;
   private string $name;
   private int $taille;
   private string $url;
   private string $dimensions;
   private string $statut;
   private DateTime $createdAt;
   private ?DateTime $publishedAt;
   private ?DateTime $uploadAt;
   private int $viewCount;
 public function __construct(   
     int $id_photo,
    string $titre ,
    string $description,
    string $name,
    int $taille,
    string $url,
    string $dimensions,
    string $statut,
    DateTime $createdAt,
    ?DateTime $publishedAt,
    ?DateTime $uploadAt,
    int $viewCount){

   $this->id_photo;
   $this->titre ;
   $this->description;
   $this->name;
   $this->taille;
   $this->url;
   $this->dimensions;
   $this->tatut;
   $this->createdAt;
   $this->publishedAt;
   $this->uploadAt;
   $this->viewCount;
 }


}
?>