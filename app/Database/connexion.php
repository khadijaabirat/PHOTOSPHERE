
<?php
class Connection {
    private ?PDO $pdo = null;

    public function getPDO(): PDO {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO(
                    "mysql:host=localhost;dbname=photosphere;charset=utf8mb4",
                    "root",
                    "",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}

?>