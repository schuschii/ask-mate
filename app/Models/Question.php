<?php

namespace App\Models;


use AllowDynamicProperties;
use DateTime;


#[AllowDynamicProperties] class Question
{


    public int $id_image;
    public int $id_registered_user;
    public string $title;
    public string $message;
    public int $vote_number;
    public DateTime $submission_time;

    /**
     * @param int $id_image
     * @param int $id_registered_user
     * @param string $title
     * @param string $message
     * @param int $vote_number
     */
    public function __construct(int $id_image, int $id_registered_user, string $title, string $message, int $vote_number)
    {
        $this->id_image = $id_image;
        $this->id_registered_user = $id_registered_user;
        $this->title = $title;
        $this->message = $message;
        $this->vote_number = $vote_number;
        $this->submission_time = new DateTime('now');
    }
}