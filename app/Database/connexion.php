
<?php
class Connection {
    private static ?PDO $connection = null;

    public static function getPDO(): PDO {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=localhost;dbname=photosphere;charset=utf8mb4",
                    "root",
                    "",
                    
                );               
                 self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

?>