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
//    $factory1 = CustomerFactory::factory('basic', 2, 'mary', 'poppins', 'marypoppins@gmail.com');
//    $factory2 = CustomerFactory::factory('premium', null, 'james', 'bond', 'james@gmail.com');
//
//    echo $factory1->getType() . '<br>';
//    echo $factory2->getType() . '<br>';

    // Singleton
    $config = Config::getInstance();

    // Connect to DB$
    $dbConfig = $config->get('db');
    $db = new PDO (
        'mysql:host=127.0.0.1;dbname=bookstore',
        $dbConfig['user'],
        $dbConfig['password']
    );
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Performing Queries
    $rows = $db->query('SELECT * FROM book ORDER BY title');
//    foreach ($rows as $row)
//        var_dump($row);

    $query = <<<'SQL'
    INSERT INTO book (isbn, title, author, price) 
    VALUES ("9788187981954", "Peter Pan", "J. M. Barrie", 2.34)
SQL;
    $result = $db->exec($query);
//    var_dump($result); // true
    $error = $db->errorInfo()[2];
//    var_dump($error); // Duplicate entry '9788187981954' for key 'isbn'

    // Prepared statements
    $query = <<<'SQL'
SELECT * FROM book WHERE author = :author
SQL;
    $statement = $db->prepare($query);
    $statement->bindValue('author','George Orwell');
    $statement->execute();
    $rows = $statement->fetchAll();
    var_dump($rows);

    $query = <<<SQL
INSERT INTO book (isbn, title, author, price)
VALUES (:isbn, :title, :author, :price)
SQL;
    $statement = $db->prepare($query);
    $params = [
        'isbn' => '9781412108614',
        'title' => 'Iliad',
        'author' => 'Homer',
        'price' => 9.25
    ];
    $statement->execute($params);
    echo $db->lastInsertId();

    // Update
    function addBook (int $id, int $amount = 1): void {
        $config = Config::getInstance();
        $dbConfig = $config->get('db');
        $db = new PDO (
            'mysql:host=127.0.0.1;dbname=bookstore',
            $dbConfig['user'],
            $dbConfig['password']
        );
        $query = <<<'SQL'
        UPDATE book SET stock = stock + :amount WHERE id = :id
SQL;
        $statement = $db->prepare($query);
        $statement->bindValue('id', $id);
        $statement->bindValue('amount', $amount);

        if (!$statement->execute())
            throw new Exception($statement->errorInfo()[2]);

    }

    addBook(1, 5);

    // Transactions
    function addSale (int $userId, array $bookIds): void {
        $config = Config::getInstance();
        $dbConfig = $config->get('db');
        $db = new PDO (
            'mysql:host=127.0.0.1;dbname=bookstore',
            $dbConfig['user'],
            $dbConfig['password']
        );

        $db->beginTransaction();
        try {
            $query = <<<'SQL'
            INSERT INTO sale (customer_id, date) 
            VALUES (:id, NOW())
SQL;
            $statement = $db->prepare($query);
            if (!$statement->execute(['id' => $userId]))
                throw new Exception($statement->errorInfo()[2]);
            $saleId = $db->lastInsertId();

            $query = <<<'SQL'
            INSERT INTO sale_book (sale_id, book_id) 
            VALUES (:sale, :book)
SQL;
            $statement = $db->prepare($query);
            $statement->bindValue('sale', $saleId);
            foreach($bookIds as $bookId) {
                $statement->bindValue('book', $bookId);
                if(!$statement->execute())
                    throw new Exception($statement->errorInfo()[2]);
            }

            $db->commit();
        }catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    // Error
//    try {
//        addSale(1, [1,2,200]);
//    } catch (Exception $e) {
//        echo 'Error adding sale: ' . $e->getMessage();
//    }

    try {
        addSale(1, [1,2,3]);
    } catch (Exception $e) {
        echo 'Error adding sale: ' . $e->getMessage();
    }



