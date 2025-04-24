<?php

namespace App\Repositories;


use App\Contracts\RepositoryInterface;
use App\Core\Database;
use PDO;

class UserRepository implements RepositoryInterface
{
    private PDO $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM registered_user";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?object
    {
        $sql = "SELECT * FROM registered_user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? (object)$result : null;
    }

    public function save(object $entity): void
    {
        $sql = "INSERT INTO registered_user (email, password_hash, registration_time) 
        VALUES (:email, :password_hash, :registration_time)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $entity->getEmail(),
            'password_hash' => password_hash($entity->getPassword(), PASSWORD_DEFAULT),
            'registration_time' => $entity->getRegistrationTime()->format('Y-m-d H:i:s')
        ]);
    }

    public function update(object $entity): void
    {
        $sql = "UPDATE registered_user SET email = :email WHERE id = :id";
        $stmt = $this->db->query($sql, [
            'id' => $entity->id,
            'email' => $entity->email
        ]);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM registered_user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function findByEmail(string $email): ?object
    {
        $sql = "SELECT * FROM registered_user WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (object)$result : null;
    }

    public function isPasswordValid(string $email, string $password): bool
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password_hash);
    }
}
