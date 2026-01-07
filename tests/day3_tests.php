<?php
require_once '../app/Database/connexion.php';
require_once '../app/Repositories/UserRepository.php';
require_once '../app/Entities/BasicUser.php';

$pdo = Connection::getPDO();
$userRepo = new UserRepository($pdo);
echo "Tester une méthode Creation d'un user :<br>";
$user = new BasicUser('chaima', 'chaima@mail.com','123');
echo "un nouveux utilisateur : " . $user->affichage() . "<br>";
$userRepo->create($user);
echo "l'ajoute d'un utilisateur : " . $user->affichage() . "<br>";
echo "ID attribué : " . $user->getid() . "<br>";

echo "Tester une méthode findById : 1 <br>";
$user = $userRepo->findById(1);
if ($user) {
    echo "user: récupéré <br> " . $user->affichage();
} else {
    echo "aucun user <br>";
}
echo "Tester une méthode update user:  <br>";
$user->setusername("aicha");
$userRepo->update($user);
echo "<br>Utilisateur modifier : " . $user->affichage() . "\n";

echo "Tester une méthode findall :  <br>";
$allUsers = $userRepo->findall();
foreach ($allUsers as $user) {
    echo $user->affichage() . "<br>";
}
 

















 echo "<h2>--- Test PhotoRepository ---</h2>";

$photoRepo = new PhotoRepository();

 $photo = new Photo(
    "MaPhoto1",
    "photo1",
    500,
    "https://example.com/photo1.jpg",
    "800x600",
    $basicUser,
    "Une belle photo",
    "Publié"
);

$photoRepo->create($photo);
echo "Photo créée avec succès.<br>";

 $photo->addTag("Nature");
$photo->addTag("Vacances");
echo "Tags ajoutés: " . implode(", ", $photo->getTags()) . "<br>";

 $photo->addLike();  
$photo->addLike();  
echo "Total Likes: " . $photo->getLikeCount() . "<br>";

   $photo->addComment("Super photo!", $basicUser->getId());
$photo->addComment("Magnifique!", $proUser->getId());
echo "Total Commentaires: " . $photo->getCommentCount() . "<br>";

    $comments = $photo->getComments();
foreach($comments as $idx => $c){
    echo "Commentaire #".($idx+1).": ".$c['content']." (UserID: ".$c['userId'].")<br>";
}

  $photo->removeTag("Vacances");
echo "Tags après suppression: " . implode(", ", $photo->getTags()) . "<br>";

 $photo->removeLike();
echo "Likes après suppression: " . $photo->getLikeCount() . "<br>";

echo "<h2>--- Test terminé ---</h2>";
?>
// $pdo = Connection::getPDO();
// $testRepo = new PhotoRepository($pdo);
// echo "Tester une méthode Creation d'une photo:<br>";
// $photo = new photo('photo1', 'description','name',14,'url','dimensions','statut');
// $testRepo->create($photo);
// echo "la photo ajouter bien  ";

?>
