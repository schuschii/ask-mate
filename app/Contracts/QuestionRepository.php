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
        return null;
    }

    /**
     * @inheritDoc
     */
    public function save(object $entity): void
    {
        // TODO: Implement save() method.
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