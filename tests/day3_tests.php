<?php
require_once '../app/Database/connexion.php';
require_once '../app/Repositories/UserRepository.php';
require_once '../app/Entities/BasicUser.php';

$pdo = Connection::getPDO();
$userRepo = new UserRepository($pdo);
echo "Tester une méthode Creation d'un user :<br>";
$user = new BasicUser('aicha', 'aicha@mail.com','123');
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
?>
