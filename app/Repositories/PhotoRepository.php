<?php 
require_once '../Entities/photo.php';
require_once '../Entities/Tag.php';
require_once '../Database/connexion.php';
require_once '../Entities/BasicUser.php';
require_once '../Entities/Tagueé.php';
class PhotoRepository{
        protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getPDO();
    }
   try{

     $this->pdo->beginTransaction();
     public function create($photo){

    $stmt=$this->pdo->prepare("insert into utilisateur(titre,description,name,taille,url,dimensions,statut, id_user,createdAt)
    values(:titre,:description,:name,:taille,:url,:dimensions,:statut,:id_user,:createdAt)");

    $stmt->execute(['titre'=>$photo->gettitre(),
                    'description'=>$photo->getdescription(),
                    'name'=>$photo->getname(),
                    'taille'=>$photo->gettaille(),
                    'url'=>$photo->geturl(),
                    'dimensions'=>$photo->getdimensions(),
                    'statut'=>$photo->getstatut(),
                    'id_user'=>$photo->getId(),
                    'createdAt' => $photo->getcreatedAt() ? $photo->getcreatedAt()->format('Y-m-d H:i:s') : null
                    ]);  

     
}
  public function findById(int $id): ?Photo {
        $stmt = $this->pdo->prepare("SELECT * FROM Photo WHERE id_photo = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
                $userStmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE id_user = :id");
        $userStmt->execute(['id' => $row['id_user']]);
        $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
        $user = new BasicUser(
            $userRow['username'], $userRow['email'], $userRow['passworde'],
            $userRow['urlphoto'], $userRow['biographie'], (int)$userRow['uploadCount']
        );
  $user->setId((int)$userRow['id_user']);

        $photo = new Photo(
            $row['titre'],
            $row['name'],
            (int)$row['taille'],
            $row['url'],
            $row['dimensions'],
            $user,
            $row['description'],
            $row['statut']
        );
        $photo->setId((int)$row['id_photo']);
        return $photo;
    }


 public function findAll(): array {
        $stmt = $this->pdo->query("SELECT id_photo FROM Photo");
        $photos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $photo = $this->findById((int)$row['id_photo']);
            if ($photo) $photos[] = $photo;
        }
        return $photos;
    }

public function update(Photo $photo): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE Photo SET titre=:titre, description=:description, name=:name, taille=:taille,
             url=:url, dimensions=:dimensions, statut=:statut WHERE id_photo=:id"
        );
        return $stmt->execute([
            'titre' => $photo->getTitre(),
            'description' => $photo->getDescription(),
            'name' => $photo->getName(),
            'taille' => $photo->getTaille(),
            'url' => $photo->getUrl(),
            'dimensions' => $photo->getDimensions(),
            'statut' => $photo->getStatut(),
            'id' => $photo->getId()
        ]);
    }

    public function delete(Photo $photo): bool {
        $stmt = $this->pdo->prepare("DELETE FROM Photo WHERE id_photo=:id");
        return $stmt->execute(['id' => $photo->getId()]);
    }
}





    public function findtag($tagname){
        $stmt=$this->pdo->prepare("select * from Tag where nom=:nom");
        $stmt->execute(['nom'=>$tagname]);
        $row=$stmt->fetch();

        if($row)
        {   
            
            $stmt=$this->pdo->prepare("insert into Tagueé(id_photo,id_tag)
    values(:id_photo,:id_tag)");

    $stmt->execute(['nom'=>$tag->getid_photo(),
                    'id_tag'=>$tag->getid_tag()
                    ]); 

        }
        else {
    $stmt=$this->pdo->prepare("insert into Tag(nom,URLfriendly)
    values(:nom,:URLfriendly)");

    $stmt->execute(['nom'=>$user->getnom(),
                    'URLfriendly'=>$user->getURLfriendly()
                    ]); 
        }
    }
    $this->pdo->commit();
    }
      catch(Exception $e){
        $this->pdo->rollBack();
        throw $e;

      }    

}


?>