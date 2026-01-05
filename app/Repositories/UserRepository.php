<?php
require_once __DIR__.'/../Database/connexion.php';
require_once __DIR__.'/RepositoryInterface.php';
require_once __DIR__.'/../Services/UserFactory.php';
require_once __DIR__.'/../Entities/User.php';
require_once __DIR__.'/../Entities/BasicUser.php';
require_once __DIR__.'/../Entities/ProUser.php';
require_once __DIR__.'/../Entities/Moderator.php';
require_once __DIR__.'/../Entities/Administrator.php';

class UserRepo implements RepositoryInterface{
    protected $pdo;

    public function __construct(Connection $connection) {
        $this->pdo = $connection->getPDO();
    }
    public function findall():array{
        $stmt=$this->pdo->query("select * from utilisateur");
        $users=[];
        
        while($row=$stmt->fetch())
        {
            $users[]=UserFactory::checkrole($row);
        }
        return $users;
    }

    public function findById(int $id){
        $stmt=$this->pdo->prepare("select * from utilisateur where id_user=:id");
        $stmt->execute(['id'=>$id]);
        $row=$stmt->fetch();

        if($row)
        {
            return $user=UserFactory::checkrole($row);
        }
        else {
            return null;
        }
    }
 public function create($user){
    $stmt=$this->pdo->prepare("insert into utilisateur(username,email,passworde,createdAt,lastLogin,role,urlphoto,biographie,uploadCount,subscriptionStart,subscriptionEnd,level,isSuperAdmin)
    values(username=:username,email=:email,passworde=:passworde,createdAt=:createdAt,lastLogin=:lastLogin,role=:role,urlphoto=:urlphoto,biographie=:biographie,uploadCount=:uploadCount,subscriptionStart=:subscriptionStart,subscriptionEnd=:subscriptionEnd,level=:level,isSuperAdmin=:isSuperAdmin)");
    $stmt->execute(['username'=>$user->getusername(),
                    'email'=>$user->getemail(),
                    'passworde'=>$user->getpassworde(),
                    'createdAt'=>$user->getcreatedAt(),
                    'lastLogin'=>$user->getlastLogin(),
                    'role'=>$user->getrole(),
                    'biographie'=>$user->getbiographie(),
                    'urlphoto'=>$user->geturlphoto(),
                    'biographie'=>$user->getbiographie(),
                    'uploadCount'=>$user->getuploadCount(),
                    'subscriptionStart'=>$user->getsubscriptionStart(),
                    'subscriptionEnd'=>$user->getsubscriptionEnd(),
                    'level'=>$user->getlevel(),
                    'isSuperAdmin'=>$user->getisSuperAdmin()
                    ]);                 
}
 

public function update($user):bool{
    $stmt=$this->pdo->prepare("update utilisateur set username=:username,email=:email,passworde=:passworde,urlphoto=:urlphoto,biographie=:biographie where id_user=:id_user");
    return $stmt->execute(['username'=>$user->getusername(),
                    'email'=>$user->getemail(),
                    'passworde'=>$user->getpassworde(),
                    'urlphoto'=>$user->geturlphoto(),
                    'biographie'=>$user->getbiographie(),
                    'id_user'=>$user->getid()
                    ]);                 
}

public function delete($user):bool{
$stmt=$this->pdo->prepare("delete from utilisateur where id_user=:id");
return $stmt->execute(['id'=>$user->getid()]);
}


}


?>