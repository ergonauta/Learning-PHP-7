<?php

    //Implementing autoloading
    use Bookstore\Domain\Book;
    use Bookstore\Domain\Customer\Basic;

    function autoloader($className) {
        $lastSlash = strpos($className, '\\') + 1;
        $className = substr($className, $lastSlash);
        $directory = str_replace('\\', '/', $className);
        $fileName = __DIR__ . '/src/' . $directory . '.php';
        require_once($fileName);
    }

    spl_autoload_register('autoloader');

    $book1 = new Book("1984", "George Orwell", 9785267006323, 12);

    $book1->printData();

    // Overriding methods
    class Pops {
        public function sayHi() {
            echo "Hi, I am pops. <br>";
        }
    }

    class Child extends Pops {
        public function sayHi() {
            echo "Hi, I am a child <br>";
            parent::sayHi();
        }
    }

    $pops = new Pops();
    $child = new Child();
    $pops->sayHi();
    $child->sayHi();

    // Inheritance
    $customer1 = new Basic(5, 'John', 'Doe', 'johndoe@gmail.com');
    var_dump(checkIfValid($customer1, [$book1]));

    function checkIfValid(Basic $customer, array $books): bool {
            return $customer->getAmountToBorrow() >= count($books);
    }

