<?php

namespace app\Controllers;

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
        include(__DIR__ . '/../Views/pages/contact.php');
    }

    public function pageNotFound()
    {
        http_response_code(404);
        include __DIR__ . '/../Views/pages/404.php';
    }
}
