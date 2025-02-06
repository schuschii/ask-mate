<?php

namespace App\Repositories;

use AllowDynamicProperties;
use App\Core\Database;
use App\Models\Tag;
use PDO;

#[AllowDynamicProperties] class TagRepository
{
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
    public function save(string $tagName): void{
        $sql = "INSERT INTO tag (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt -> execute(['name'=>$tagName]);
    }
    public function delete(int $id): void{
        $sql = "DELETE FROM tag WHERE id_question = :id_question";
        $stmt = $this->db->prepare($sql);
        $stmt -> execute(['id' => $id]);
    }

}