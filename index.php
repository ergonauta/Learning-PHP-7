<?php

    require_once __DIR__ . '/vendor/autoload.php';

    use Bookstore\Models\BookModel;
    use Bookstore\Models\SaleModel;
    use Bookstore\Core\Db;

    $loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
    $twig = new Twig_Environment($loader);

    // Book View
    $bookModel = new BookModel(Db::getInstance());
    $book = $bookModel->getAll(1,3);

    $params = ['books' => $books, 'currentPage' => 2];
    echo $twig->loadTemplate('book.twig')->render($params);

    // Sale View
    $saleModel = new SaleModel(Db::getInstance());
    $sales = $saleModel->getByUser(1);

    $params = ['sales' => $sales];
    echo $twig->loadTemplate('sales.twig')->render($params);

    $saleModel = new SaleModel(Db::getInstance());
    $sales = $saleModel->get(1);

    $params = ['sale' => $sale];
    echo $twig->loadTemplate('sale.twig')->render($params);

