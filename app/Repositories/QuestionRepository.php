<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use App\Core\Database;
use PDO;

class QuestionRepository implements RepositoryInterface
{
    private ?PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }
    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
    $sql = "SELECT * FROM question ORDER BY submission_time" ;
    $result = $this->connection->query($sql);
    return $result->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?object
    {
        $sql = "SELECT * FROM question WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result !== false ? $result : null;
    }

    /**
     * @inheritDoc
     */
    public function save(object $entity): void
    {
        $sql = "INSERT INTO question (title, message, vote_number, id_registered_user) VALUES (:title, :message, 0, :id_registered_user)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':title', $entity->title);
        $stmt->bindParam(':message', $entity->message);
        $stmt->bindParam(':id_registered_user', $entity->id_registered_user);
        $stmt->execute();
    }

    public function getLastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /**
     * @inheritDoc
     */
    public function update(object $entity): void
    {
        $sql = "UPDATE question SET title = :title, message = :message WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':title', $entity->title, PDO::PARAM_STR);
        $stmt->bindParam(':message', $entity->message, PDO::PARAM_STR);
        $stmt->bindParam(':id', $entity->id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void       // this or: ON DELETE CASCADE in the database
    {
        // Step 1: Delete all answers associated with the question
        $sql = "DELETE FROM answer WHERE id_question = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Step 2: Delete the question
        $sql = "DELETE FROM question WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function countQuestionsByTag(int $tagId): int
    {
        $sql = "SELECT COUNT(*) as question_count 
                FROM rel_question_tag 
                WHERE id_tag = :tag_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['tag_id' => $tagId]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result ? (int) $result->question_count : 0;
    }
    public function findQuestionsByTag(int $tagId): array
    {
        $sql = "SELECT q.* FROM questions q
                INNER JOIN rel_question_tag qt ON q.id = qt.id_question
                WHERE qt.id_tag = :tag_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['tag_id' => $tagId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



    public function searchQuestion(string $search): array
    {
        $sql = "SELECT * FROM question WHERE title LIKE :search OR message LIKE :search";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR); //passes values directly
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}