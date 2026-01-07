


<?php
require_once '../Entities/BasicUser.php';
require_once '../Entities/Photo.php';
class Album
{
    private ?int $id_album = null;
    private string $nom;
    private ?string $description = null;
    private ?int $coverphoto_id = null;
    private DateTime $createdAt;
    private ?DateTime $uploadAt = null;
    private int $photoCount = 0;
    private string $parametreBinaire; 
    private BasicUser $BasicUser;
    private array $photos = [];

    public function __construct(
        string $nom,
        BasicUser $BasicUser,
        string $parametreBinaire,
        ?string $description = null
    ) {
        $this->nom = $nom;
        $this->BasicUser = $BasicUser;
        $this->parametreBinaire = $parametreBinaire; 
        $this->description = $description;
        $this->createdAt = new DateTime();
    }

    public function getIdAlbum(): ?int
    {
        return $this->id_album;
    }

    public function setIdAlbum(int $id_album): void
    {
        $this->id_album = $id_album;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCoverPhotoId(): ?int
    {
        return $this->coverphoto_id;
    }

    public function setCoverPhotoId(?int $coverphoto_id): void
    {
        $this->coverphoto_id = $coverphoto_id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUploadAt(): ?DateTime
    {
        return $this->uploadAt;
    }

    public function setUploadAt(?string $uploadAt): void
    {
        $this->uploadAt = $uploadAt;
    }

    public function getPhotoCount(): int
    {
        return $this->photoCount;
    }

    public function setPhotoCount(int $photoCount): void
    {
        $this->photoCount = $photoCount;
    }

    public function getParametreBinaire(): string
    {
        return $this->parametreBinaire;
    }

    public function setParametreBinaire(string $parametreBinaire): void
    {
        $this->parametreBinaire = $parametreBinaire;
    }

    public function getUser(): BasicUser
    {
        return $this->BasicUser;
    }

    public function setUser(BasicUser $BasicUser): void
    {
        $this->BasicUser = $BasicUser;
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): void
    {
        $this->photos[] = $photo;
        $this->photoCount++;
    }

    public function removePhoto(Photo $photo): void
    {
        foreach ($this->photos as $key => $p) {
            if ($p === $photo) {
                unset($this->photos[$key]);
                $this->photoCount--;
                break;
            }
        }
        $this->photos = array_values($this->photos);
    }

    public function clearPhotos(): void
    {
        $this->photos = [];
        $this->photoCount = 0;
    }
}
