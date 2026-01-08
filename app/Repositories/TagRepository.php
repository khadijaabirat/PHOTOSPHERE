<?php
require_once '/';

class TagRepository {

    protected $pdo;

    public function __construct() {
        $this->pdo = Connection::getPDO();
    }


    public function getPopularTags(int $limit = 50): array {
        $stmt = $this->pdo->prepare("
            SELECT t.name, COUNT(pt.photo_id) AS usage_count
            FROM tags t
            JOIN photo_tags pt ON t.id = pt.tag_id
            GROUP BY t.id
            ORDER BY usage_count DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function searchTags(string $query, int $limit = 20): array {
        $query = strtolower($query);

        $stmt = $this->pdo->prepare("
            SELECT t.name, COUNT(pt.photo_id) AS usage_count
            FROM tags t
            LEFT JOIN photo_tags pt ON t.id = pt.tag_id
            WHERE LOWER(t.name) LIKE :q
            GROUP BY t.id
            ORDER BY usage_count DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':q', $query.'%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function getPhotosByTag(string $tagName, int $page = 1, int $perPage = 30): array {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->pdo->prepare("SELECT id FROM tags WHERE name = :name");
        $stmt->execute(['name'=>$tagName]);
        $tag = $stmt->fetch();
        if(!$tag) return [];

        $tagId = $tag['id'];

        $totalStmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM photo_tags WHERE tag_id = :tagId
        ");
        $totalStmt->execute(['tagId'=>$tagId]);
        $total = (int)$totalStmt->fetchColumn();

        $stmt = $this->pdo->prepare("
            SELECT p.*
            FROM photos p
            JOIN photo_tags pt ON p.id_photo = pt.photo_id
            WHERE pt.tag_id = :tagId
            LIMIT :offset, :perPage
        ");
        $stmt->bindValue(':tagId', $tagId, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'photos' => $stmt->fetchAll(),
        ];
    }


    public function getTagStats(string $tagName): array {
        $stmt = $this->pdo->prepare("SELECT id FROM tags WHERE name=:name");
        $stmt->execute(['name'=>$tagName]);
        $tag = $stmt->fetch();
        if(!$tag) return [];

        $tagId = $tag['id'];

        $totalStmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM photo_tags WHERE tag_id=:tagId
        ");
        $totalStmt->execute(['tagId'=>$tagId]);
        $totalPhotos = (int)$totalStmt->fetchColumn();

        $monthlyStmt = $this->pdo->prepare("
            SELECT MONTH(p.createdAt) AS month, COUNT(*) AS count
            FROM photos p
            JOIN photo_tags pt ON p.id_photo = pt.photo_id
            WHERE pt.tag_id = :tagId
            GROUP BY MONTH(p.createdAt)
        ");
        $monthlyStmt->execute(['tagId'=>$tagId]);
        $byMonth = $monthlyStmt->fetchAll();

        return [
            'tag' => $tagName,
            'totalPhotos' => $totalPhotos,
            'byMonth' => $byMonth
        ];
    }


    public function mergeTags(string $fromTag, string $toTag): bool {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("SELECT id FROM tags WHERE name=:name");
            $stmt->execute(['name'=>$fromTag]);
            $from = $stmt->fetch();

            $stmt->execute(['name'=>$toTag]);
            $to = $stmt->fetch();

            if(!$from || !$to) {
                $this->pdo->rollBack();
                return false;
            }

            $update = $this->pdo->prepare("
                UPDATE photo_tags SET tag_id=:toId WHERE tag_id=:fromId
            ");
            $update->execute([
                'toId'=>$to['id'],
                'fromId'=>$from['id']
            ]);

            $delete = $this->pdo->prepare("DELETE FROM tags WHERE id=:id");
            $delete->execute(['id'=>$from['id']]);

            $this->pdo->commit();
            return true;

        } catch(Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
?>
