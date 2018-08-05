<?php

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    use Bookstore\Core\Router;
    use Bookstore\Core\Request;
    use Bookstore\Core\Config;
    use Bookstore\Utils\DependencyInjector;
    use Bookstore\Models\BookModel;

    require_once __DIR__ . '/vendor/autoload.php';

    $config = new Config();

    $dbConfig = $config->get('db');
    $db = new PDO(
        'mysql:host=127.0.0.1;dbname=bookstore',
        $dbConfig['user'],
        $dbConfig['password']
    );

    $loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
    $view = new Twig_Environment($loader);

    $log = new Logger('bookstore');
    $logFile = $config->get('log');
    $log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

    $di = new DependencyInjector();
    $di->set('PDO', $db);
    $di->set('Utils\Config', $config);
    $di->set('Twig_Environment', $view);
    $di->set('Logger', $log);
    $di->set('BookModel', new BookModel($di->get('PDO')));

    $router = new Router($di);
    $response = $router->route(new Request());
    echo $response;