<?php
require_once '../Entities/BasicUser.php';
require_once '../Entities/Photo.php';
class Commentaire
{
    private ?int $id_commentaire = null;
    private string $contenu;
    private BasicUser $BasicUser;
    private Photo $photo;
    private DateTime $createdAt;
    private ?DateTime $lastUpdate = null;

    public function __construct(
        string $contenu,
        BasicUser $BasicUser,
        Photo $photo
    ) {
        $this->contenu = $contenu;
        $this->BasicUser = $BasicUser;
        $this->photo = $photo;
        $this->createdAt = new DateTime();
    }
 public function getIdCommentaire(): ?int
    {
        return $this->id_commentaire;
    }

    public function setIdCommentaire(int $id): void
    {
        $this->id_commentaire = $id;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
        $this->lastUpdate = new DateTime();
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
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getLastUpdate(): ?DateTime
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(?DateTime $lastUpdate): void
    {
        $this->lastUpdate = $lastUpdate;
    }
}

