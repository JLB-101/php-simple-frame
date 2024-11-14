<?php

namespace App\Controllers;

class PageController
{
    public function home()
    {
        include __DIR__ . '/../app/Views/home.php';
    }

    public function about()
    {
        include __DIR__ . '/../Views/pages/about.php';
    }

    public function contact()
    {
        include(__DIR__ . '/../Views/pages/contact.php');
    }

    public function pageNotFound()
    {
        include __DIR__ . '/../app/Views/pages/404.php';
    }
}
