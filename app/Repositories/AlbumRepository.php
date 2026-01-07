<?php
require_once __DIR__.'/../Database/connexion.php';
require_once __DIR__.'/../Entities/Album.php';
require_once __DIR__.'/../Entities/Photo.php';
require_once __DIR__.'/../Entities/BasicUser.php';

class AlbumRepository {
    protected $pdo;

    public function __construct() {
        $this->pdo = Connection::getPDO();
    }
 
    public function createAlbum(int $userId, string $title, string $description, bool $isPrivate): int {
         $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Album WHERE BasicUser_id = :userId AND nom = :title");
        $stmt->execute(['userId'=>$userId, 'title'=>$title]);
        if($stmt->fetchColumn() > 0) {
            throw new Exception("le title est deja exsiste ");
        }

         if($isPrivate) {
            $stmt = $this->pdo->prepare("SELECT role FROM utilisateur WHERE id_user=:userId");
            $stmt->execute(['userId'=>$userId]);
            $role = $stmt->fetchColumn();
            if($role !== 'Moderator' && $role !== 'Administrateur') {
                throw new Exception("ils ont pas l'acceé pour creé des alboms");
            }
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO Album (nom, description, parametreBinaire, BasicUser_id, createdAt) 
             VALUES (:nom, :description, :isPrivate, :userId, :createdAt)"
        );
        $stmt->execute([
            'nom' => $title,
            'description' => $description,
            'isPrivate' => $isPrivate ? 1 : 0,
            'userId' => $userId,
            'createdAt' => (new DateTime())->format('Y-m-d H:i:s')
        ]);

        return (int)$this->pdo->lastInsertId();
    }
 
    public function addPhotoToAlbum(int $albumId, int $photoId, int $userId): bool {
         $stmt = $this->pdo->prepare("SELECT BasicUser_id FROM Album WHERE id_album=:albumId");
        $stmt->execute(['albumId'=>$albumId]);
        $ownerId = $stmt->fetchColumn();
        if($ownerId != $userId) return false;

         $stmt = $this->pdo->prepare("SELECT BasicUser_id FROM Photo WHERE id_photo=:photoId");
        $stmt->execute(['photoId'=>$photoId]);
        $photoOwnerId = $stmt->fetchColumn();
        if($photoOwnerId != $userId) return false;

         $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Album_Photo WHERE Album_id=:albumId");
        $stmt->execute(['albumId'=>$albumId]);
        if($stmt->fetchColumn() >= 100) return false;

         $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Album_Photo WHERE Album_id=:albumId AND Photo_id=:photoId");
        $stmt->execute(['albumId'=>$albumId, 'photoId'=>$photoId]);
        if($stmt->fetchColumn() > 0) return false;

        $stmt = $this->pdo->prepare("INSERT INTO Album_Photo (Album_id, Photo_id) VALUES (:albumId, :photoId)");
        return $stmt->execute(['albumId'=>$albumId, 'photoId'=>$photoId]);
    }
 
    public function removePhotoFromAlbum(int $albumId, int $photoId, int $userId): bool {
         $stmt = $this->pdo->prepare("SELECT BasicUser_id FROM Album WHERE id_album=:albumId");
        $stmt->execute(['albumId'=>$albumId]);
        $ownerId = $stmt->fetchColumn();
        if($ownerId != $userId) return false;

        $stmt = $this->pdo->prepare("DELETE FROM Album_Photo WHERE Album_id=:albumId AND Photo_id=:photoId");
        return $stmt->execute(['albumId'=>$albumId, 'photoId'=>$photoId]);
    }
 
    public function getAlbumWithPhotos(int $albumId, int $userId): ?array {
        $stmt = $this->pdo->prepare(
            "SELECT a.*, u.username FROM Album a 
             JOIN utilisateur u ON a.BasicUser_id = u.id_user
             WHERE a.id_album=:albumId"
        );
        $stmt->execute(['albumId'=>$albumId]);
        $album = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$album) return null;

         if($album['parametreBinaire'] == 1 && $album['BasicUser_id'] != $userId) return null;

        $stmt = $this->pdo->prepare(
            "SELECT p.* FROM Photo p 
             JOIN Album_Photo ap ON p.id_photo = ap.Photo_id 
             WHERE ap.Album_id = :albumId"
        );
        $stmt->execute(['albumId'=>$albumId]);
        $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $album['photos'] = $photos;
        return $album;
    }

  
    public function getUserAlbums(int $userId, bool $includePrivate = true): array {
        $query = "SELECT * FROM Album WHERE BasicUser_id=:userId";
        if(!$includePrivate) $query .= " AND parametreBinaire=0";
        $query .= " ORDER BY updatedAt DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['userId'=>$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 
    public function updateAlbum(int $albumId, int $userId, array $data): bool {
        $stmt = $this->pdo->prepare("SELECT BasicUser_id FROM Album WHERE id_album=:albumId");
        $stmt->execute(['albumId'=>$albumId]);
        if($stmt->fetchColumn() != $userId) return false;

        $fields = [];
        $params = ['albumId'=>$albumId];
        if(isset($data['title'])) { $fields[]="nom=:title"; $params['title']=$data['title']; }
        if(isset($data['description'])) { $fields[]="description=:description"; $params['description']=$data['description']; }
        if(isset($data['isPrivate'])) { $fields[]="parametreBinaire=:isPrivate"; $params['isPrivate']=$data['isPrivate'] ? 1 : 0; }

        if(empty($fields)) return false;

        $sql = "UPDATE Album SET ".implode(',', $fields)." WHERE id_album=:albumId";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

  
    public function deleteAlbum(int $albumId, int $userId): bool {
        $stmt = $this->pdo->prepare("SELECT BasicUser_id FROM Album WHERE id_album=:albumId");
        $stmt->execute(['albumId'=>$albumId]);
        if($stmt->fetchColumn() != $userId) return false;

        $stmt = $this->pdo->prepare("DELETE FROM Album WHERE id_album=:albumId");
        return $stmt->execute(['albumId'=>$albumId]);
    }
}
?>
