<?php

    use Bookstore\Core\Router;
    use Bookstore\Core\Request;

    require_once __DIR__ . '/vendor/autoload.php';

    $router = new Router();
    $response = $router->route(new Request());
    echo $response;

