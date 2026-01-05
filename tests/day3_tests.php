<?php
require_once 'Connection.php';
require_once 'Repositories/UserRepository.php';

$connection = new Connection();
$userRepo = new UserRepository($connection);

$allUsers = $userRepo->findAll();
foreach ($allUsers as $user) {
    echo $user->getUsername() . "\n";
}

$user = $userRepo->findById(1);
if ($user) {
    echo "User: " . $user->getUsername();
}
?>
