<?php

namespace App\Models;

use DateTime;

class Answer
{

    public int $id_question;
    public int $id_registered_user;
    public string $message;
    public int $vote_number = 0;
    public DateTime $submission_time;

    public function __construct( int $id_question, int $id_registered_user, string $message, int $votes)
    {

        $this->id_question = $id_question;
        $this->id_registered_user = $id_registered_user;
        $this->message = $message;
        $this->vote_number = $votes;
        $this->submission_time = new DateTime('now');
    }
    public function setMessage($message): void
    {
        $this->message = htmlentities($message);
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

    public function getVotenumer(): int
    {
        return $this->vote_number;
    }
}