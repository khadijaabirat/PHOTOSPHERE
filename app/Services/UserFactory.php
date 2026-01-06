    
    
    <?php
    require_once __DIR__.'/../Entities/User.php';
    require_once __DIR__.'/../Entities/BasicUser.php';
    require_once __DIR__.'/../Entities/ProUser.php';
    require_once __DIR__.'/../Entities/Moderator.php';
    require_once __DIR__.'/../Entities/Administrator.php';

    class  UserFactory {
        public static function checkrole($row){
        if($row['role']=='BasicUser')
        {
            $user=new BasicUser($row['username'],$row['email'],$row['passworde'],$row['urlphoto'],$row['biographie'],$row['uploadCount']);
            $user->setId($row['id_user']);
            return $user;
        }
        else if($row['role']=='ProUser')
        {
            $user=new ProUser($row['username'],$row['email'],$row['passworde'],$row['urlphoto'],$row['biographie'],$row['uploadCount'],$row['subscriptionStart'],$row['subscriptionEnd']);
            $user->setId($row['id_user']);
            return $user;
        }
        else if($row['role']=='Administrateur')
        {
            $user=new Administrator($row['username'],$row['email'],$row['passworde'],$row['urlphoto'],$row['biographie'],$row['isSuperAdmin']);
            $user->setId($row['id_user']);
            return $user;
        }
        else if($row['role']=='Moderator')
        {
            $user=new Moderator($row['username'],$row['email'],$row['passworde'],$row['urlphoto'],$row['biographie'], $row['level']);
            $user->setId($row['id_user']);
            return $user;
        }
        
        else echo "ce role est n'existe pas";
        return null;
    }}

    ?>
    
    
