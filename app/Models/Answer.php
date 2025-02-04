<?php

namespace App\Models;

use DateTime;

class Answer
{
    private int $id;
    private int $id_question;
    private int $id_registered_user;
    private string $message;
    private int $votes = 0;
    private DateTime $submission_time;

    public function __construct(int $id, int $id_question, int $id_registered_user, string $message, int $votes)
    {
        $this->id = $id;
        $this->id_question = $id_question;
        $this->id_registered_user = $id_registered_user;
        $this->message = $message;
        $this->votes = $votes;
        $this->submission_time = new DateTime('now');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdQuestion(): int
    {
        return $this->id_question;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getIdRegisteredUser(): int
    {
        return $this->id_registered_user;
    }

    public function getVotes(): int
    {
        return $this->votes;
    }
}