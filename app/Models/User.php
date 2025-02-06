<?php

namespace App\Models;

use DateTime;

class User
{
    private string $email;
    private string $password;

    private DateTime $registration_time;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->registration_time = new DateTime('now');
    }

    public function getRegistrationTime(): DateTime
    {
        return $this->registration_time;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}