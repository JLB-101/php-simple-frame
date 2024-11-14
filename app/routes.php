<?php 

use piecing\routing\Router;

return function(Router $router) {
    $router->add(
        'GET', '/',
        fn()=> include(__DIR__ . '/../app/Views/home.php'),
    );
    
    $router->add('GET', '/old-home', fn()=>$router->redirect('/'), );

    $router->add('GET', '/has-server-error', fn()=> throw new Exception(), );

    $router->add('GET', '/has-validation-error', fn()=> $router->dispatchNotAllowed(), );

    $router->errorHandler(404, fn() => 'whoops!');
    

};