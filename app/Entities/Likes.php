
<?php
require_once './BasicUser.php';
require_once './Photo.php';
class Likes
{
    private ?int $id_like = null;
    private BasicUser $BasicUser;
    private Photo $photo;
    private DateTime $createdAt;

    public function __construct(
        BasicUser $BasicUser,
        Photo $photo
    ) {
        $this->BasicUser = $BasicUser;
        $this->photo = $photo;
        $this->createdAt = new DateTime();
    }

    public function getIdLike(): ?int
    {
        return $this->id_like;
    }

    public function setIdLike(int $id_like): void
    {
        $this->id_like = $id_like;
    }

     public function getUser(): BasicUser
    {
        return $this->BasicUser;
    }

    public function setUser(BasicUser $BasicUser): void
    {
        $this->BasicUser = $BasicUser;
    }

     public function getPhoto(): Photo
    {
        return $this->photo;
    }

    public function setPhoto(Photo $photo): void
    {
        $this->photo = $photo;
    }

     public function getcreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setcreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
