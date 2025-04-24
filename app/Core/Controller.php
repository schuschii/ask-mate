<?php

namespace App\Core;

use eftec\bladeone\BladeOne;

abstract class Controller
{
    protected BladeOne $blade;

    public function __construct()
    {
        session_start();
        $this->blade = Template::getInstance();
    }

    protected function render(string $view, array $data = []): void
    {
        echo $this->blade->run($view, $data);
    }
}
