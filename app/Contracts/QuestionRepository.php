<?php

namespace App\Contracts;

use App\Contracts\RepositoryInterface;
use PDO;

class QuestionRepository implements RepositoryInterface
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
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
        $sql = "INSERT INTO question (title, message, vote_number) VALUES (:title, :message, 0)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':title', $entity->title);
        $stmt->bindParam(':message', $entity->message);
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
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }


}