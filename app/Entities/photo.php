<?php
require_once '../Entities/BasicUser.php';
require_once '../Interfaces/Commentable.php';
require_once '../Interfaces/Likeable.php';
require_once '../Interfaces/Taggable.php';
require_once '../Traits/TaggableTrait.php';
require_once '../Traits/TimestampableTrait.php';

class Photo implements  Commentable, Likeable, Taggable  {
  use TaggableTrait, TimestampableTrait;


   private ?int $id_photo=null;
   private string $titre ;
   private ?string $description=null;
   private string $name;
   private int $taille;
   private string $url;
   private string $dimensions;
   private string $statut="brouillon";
   private DateTime $createdAt;
   private ?DateTime $uploadAt=null;
   private int $viewCount=0;
   private BasicUser $BasicUser;
       private array $tags = [];
    private array $likes = [];
    private array $comments =[];
       private int $likeCount = 0;
    private int $commentCount = 0;
    private bool $isPublic = true;
 public function __construct(   
    string $titre ,
    string $description=null,
    string $name,
    int $taille,
    string $url,
    string $dimensions,
    string $statut = "brouillon",
    int $viewCount=0,
    BasicUser $BasicUser){

   $this->titre=$titre;
   $this->description=$description;
   $this->name=$name;
   $this->taille=$taille;
   $this->url=$url;
   $this->dimensions=$dimensions;
   $this->statut=$statut;
   $this->viewCount = $viewCount;
    $this->BasicUser = $BasicUser;
 }
   public function getId(): ?int {
     return $this->id_photo; }

public function gettitre():string{
 return $this->titre;
}
public function getdescription():?string{
 return $this->description;
}
public function getname():string{
  return $this->name;
}
    public function getTaille(): int { 
      return $this->taille; }

public function geturl():string{
 return $this->url;
}
public function getdimensions():string{
 return $this->dimensions;
}
public function getstatut():string{
 return $this->statut;
}
public function getcreatedAt():DateTime{
 return $this->createdAt;
}
public function getuploadAt():DateTime{
 return $this->uploadAt;
}
public function getviewCount(): int{
 return $this->viewCount;
}
    public function getUser(): BasicUser { 
      return $this->BasicUser; }

    public function getCommentCount(): int {
        return $this->commentCount;
    }
   


    public function addComment(string $content,int $userId): int {
      $id=count($this->comments)+1;
      $this->comments[id]=['userId'=>$userId,'content'=>$content];

      $this->commentCount++;
      return $id;
    }

 public function removeComment(int $commentId): bool {
        if(isset($this->comments[$commentId])){
            unset($this->comments[$commentId]);
            $this->commentCount--;
            return true;
        }
        return false;
    }
       public function getComments(): void {
        return $this->comments;
    }

    
    public function getLikeCount(): int {
        return $this->likeCount;
    }

      public function addLike(int $userId): bool {
        if(!isset($this->likes[$userId])){
            $this->likes[$userId] = true;
            $this->likeCount++;
            return true;
        }
        return false;
    }
        public function removeLike(int $userId): bool {
        if(isset($this->likes[$userId])){
            unset($this->likes[$userId]);
            $this->likeCount--;
            return true;
        }
        return false;
    }
     public function isLikedBy(int $userId): bool {
        return isset($this->likes[$userId]);
    }


    public function getLikedBy(): array {
        return array_keys($this->likes);
    }


 

    

    public function isPublic(): bool {
        return $this->isPublic;
    }

    public function setPublic(bool $public): void {
        $this->isPublic = $public;
    }

}
?>