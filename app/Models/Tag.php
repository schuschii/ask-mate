<?php

namespace App\Models;

class Tag
{
    public string $name;


    public function __construct(string $name)
    {
        $this->name = $name;
    }

}