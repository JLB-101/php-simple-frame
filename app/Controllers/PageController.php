<?php

namespace App\Controllers;

class PageController
{
    public function home()
    {
        include __DIR__ . '/../Views/home.php';
    }

    public function about()
    {
        include __DIR__ . '/../Views/pages/about.php';
    }

    public function contact()
    {
        include __DIR__ . '/../Views/pages/contact.php';
    }
}
