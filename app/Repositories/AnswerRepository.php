<?php

namespace App\Repositories;

use AllowDynamicProperties;
use App\Contracts\RepositoryInterface;
use App\Core\Database;
use PDO;

#[AllowDynamicProperties] class AnswerRepository implements RepositoryInterface
{


    public function __construct()
    {

        $this->db = Database::getConnection();
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM answer"; //queryvel kiszedek minden kérdést a táblából
        $stmt = $this->db->query($sql);//egy pdo class method arra hogy elvégezze a queryt
        return $stmt->fetchAll(PDO::FETCH_OBJ); //lefetchel mindent mint egy associative array
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?object
    {
        $sql = "SELECT * FROM answer WHERE id = :id";
        $stmt = $this->db->prepare($sql); //előkészíti a queryt mielőtt végrehajtaná, data ként fogja kezelni az id-t így nem tudják droppolni vagy lekérni az egészet
        $stmt->execute(['id' => $id]); // helyettesíti a placeholdert a valós id value val majd végre hajtja a queryt
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? (object)$result : null;
    }
    public function findByQuestion(int $question_id): array
    {
        $sql = "SELECT * FROM answer WHERE id_question = :question_id ORDER BY submission_time ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['question_id' => $question_id]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @inheritDoc
     */
    public function save(object $entity): void
    {
        $sql = "INSERT INTO answer (id_question, id_registered_user, message, vote_number) VALUES (:id_question, :id_registered_user, :message, :vote_number)";
        $stmt = $this->db->prepare($sql); // ugyanúgy sql injection ellen véd
        $stmt->execute(['id_question' => $entity->id_question,
            'id_registered_user' => $entity->id_registered_user,
            'message' => $entity->message,
            'vote_number' => $entity->vote_number]);
    }


    /**
     * @inheritDoc
     */
    public function update(object $entity): void
    {
        $sql = "UPDATE answer SET message = :message WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $entity->id,
            'message' => $entity->message,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM answer WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}