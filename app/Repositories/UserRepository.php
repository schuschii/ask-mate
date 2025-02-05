<?php

namespace App\Repositories;

use AllowDynamicProperties;
use App\Contracts\RepositoryInterface;
use App\Core\Controller;
use App\Core\Database;
use App\Model\User;
use PDO;

#[AllowDynamicProperties] class UserRepository implements RepositoryInterface
{
    private PDO $db;
    public function __construct()
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

    public function save(object $user): void
    {
        $sql = "INSERT INTO registered_user (email, password_hash, registration_time) 
        VALUES (:email, :password_hash, :registration_time)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $user->getEmail(),
            'password_hash' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'registration_time' => $user->getRegistrationTime()->format('Y-m-d H:i:s')
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
