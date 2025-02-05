<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use App\Core\Controller;
use PDO;

#[AllowDynamicProperties] class UserRepository implements RepositoryInterface
{
    public function index(): void
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM resitered_user";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?object
    {
        $sql = "SELECT * FROM resitered_user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? (object)$result : null;
    }

    public function save(object $entity): void
    {
        $sql = "INSERT INTO resitered_user (name, email) VALUES (:name, :email)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name' => $entity->name,
            'email' => $entity->email
        ]);
    }

    public function update(object $entity): void
    {
        $sql = "UPDATE registered_user SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->query($sql, [
            'id' => $entity->id,
            'name' => $entity->name,
            'email' => $entity->email
        ]);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM registered_user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}
