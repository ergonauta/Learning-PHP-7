<?php

    use Bookstore\Domain\Customer\CustomerFactory;
    use Bookstore\Utils\Config;

    function autoloader($className) {
        $lastSlash = strpos($className, '\\') + 1;
        $className = substr($className, $lastSlash);
        $directory = str_replace('\\', '/', $className);
        $fileName = __DIR__ . '/src/' . $directory . '.php';
        require_once($fileName);
    }

    spl_autoload_register('autoloader');

    // Design patterns

    // Factory
    $factory1 = CustomerFactory::factory('basic', 2, 'mary', 'poppins', 'marypoppins@gmail.com');
    $factory2 = CustomerFactory::factory('premium', null, 'james', 'bond', 'james@gmail.com');

    echo $factory1->getType() . '<br>';
    echo $factory2->getType() . '<br>';

    // Singleton
    $config = Config::getInstance();
    $dbConfig = $config->get('db');
    var_dump($dbConfig);