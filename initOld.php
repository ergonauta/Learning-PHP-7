<?php

    use Bookstore\Domain\Book;
    use Bookstore\Domain\Person;
    use Bookstore\Domain\Customer\Basic;
    use Bookstore\Domain\Customer\Premium;
    use Bookstore\Utils\Unique;
    use Bookstore\Exceptions;
    use Bookstore\Exceptions\InvalidIdException;
    use Bookstore\Exceptions\ExceededMaxAllowedException;

    //Implementing autoloading
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

    // Traits
    $basic1 = new Basic(1, "name", "surname", "email");
    $basic2 = new Basic((int)null, "name", "surname", "email");
    var_dump($basic1->getId());
    var_dump($basic2->getId());

    $basic = new Basic(1, "name", "surname", "email");
    $premium = new Premium((int)null, "name", "surname", "email");
    var_dump($basic->getId()); // 1
    var_dump($premium->getId()); // 2

    var_dump(Person::getLastId()); // 2
    var_dump(Unique::getLastId()); // 0
    var_dump(Basic::getLastId()); // 2
    var_dump(Premium::getLastId()); // 2

    // Handling Exceptions
    try {
        $basic = new Basic(-1, "name", "surname", "email");
    } catch (Exception $e) {
        echo 'Something happened when creating the basic customer: ' . $e->getMessage();
    }

    // The finally block
    function createBasicCustomer($id){
        try {
            echo "\nTrying to create a new customer.\n";
            return new Basic($id, "name", "surname", "email");
        } catch (InvalidIdException $e) {
            echo "Somethig happened when creating the basic customer: "
                . $e->getMessage();
        } catch (ExceededMaxAllowedException $e) {
            echo "No more customers are allowed.\n";
        } catch (Exception $e) {
            echo "Unknown exception: " . $e->getMessage();
        }
    }

    createBasicCustomer(1);
    createBasicCustomer(-1);
    createBasicCustomer(55);

