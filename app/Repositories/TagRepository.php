<?php

namespace App\Repositories;


use App\Core\Database;
use PDO;

class TagRepository
{
    private ?PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM tag";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function save(string|object $entity): void
    {
        $sql = "INSERT INTO tag (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['name' => $entity]);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM tag WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    //findTagsByQuestion
    public function find(int $id): array
    {
        $sql = "SELECT t.* 
            FROM tag t
            INNER JOIN rel_question_tag r ON t.id = r.id_tag
            WHERE r.id_question = :questionId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['questionId' => $id]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function assignTagToQuestion(int $questionId, int $tagId): void
    {
        $sql = "INSERT IGNORE INTO rel_question_tag (id_question, id_tag) VALUES (:question_id, :tag_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'question_id' => $questionId,
            'tag_id' => $tagId
        ]);
    }

    public function removeTagFromQuestion(mixed $questionId, mixed $tagId): void
    {
        $sql = "DELETE FROM rel_question_tag WHERE id_question = :question_id AND id_tag = :tag_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'question_id' => $questionId,
            'tag_id' => $tagId
        ]);
    }

}