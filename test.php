<?php

    function testBook() {
        $testBook = new Book(9785267006323,"1984", "George Orwell", 12);
        $testBook2 = new Book(9780061120084, "To Kill a Mockingbird", "Harper Lee", 2);

        if($testBook->getCopy())
            echo 'Here, your copy.';
        else
            echo 'I am afraid that book is not available';

        echo '<br>' . $testBook->printInfo();
        echo '<br>' . $testBook2->printInfo();
    }

    function testCustomer () {
        $customer1 = new Customer(3, 'John', 'Doe', 'johndoe@mail.com');
        $customer2 = new Customer((int)null, 'Mary', 'Poppins', 'mp@mail.com');
        $customer3 = new Customer(7, 'James', 'Bond', '007@mail.com');

        echo $customer1->printData() . '<br>';
        echo $customer2->printData() . '<br>';
        echo $customer3->printData() . '<br>';

        echo Customer::getLastID() . '<br>';
    }

//    testBook();
    testCustomer();

