<?php

namespace App\Controllers;

use App\Core\Controller;

class UserController extends Controller
{
    public function showUser($id): void
    {
        echo "User ID: " . htmlspecialchars($id);
    }
}
