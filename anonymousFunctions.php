<?php

    $addTaxes = function (array &$book, $index, $percentage) {
                    $book['price'] += round($percentage * $book['price'], 2);
                };

    $books = [
        ['title' => '1984', 'price' => 8.15],
        ['title' => 'Don Quijote', 'price' => 12.00],
        ['title' => 'Odyssey', 'price' => 3.55]
    ];

//    foreach ($books as $index => $book) {
//        $addTaxes($book, $index, 0.16);
//    }

//    var_dump($books);

    // We can use array_walk instead of foreach
//    $percentage = 0.16;
//    array_walk($books, $addTaxes, $percentage);
//
//    var_dump($books);


    // Another example
    function addTaxes(array &$book, $index, $percentage) {
        if (isset($book['price'])) {
            $book['price'] += round($percentage * $book['price'], 2);
        }
    }

    class Taxes {
        public static function add(array &$book, $index, $percentage){
            if (isset($book['price'])) {
                $book['price'] += round($percentage * $book['price'], 2);
            }
        }
        public function addTaxes(array &$book, $index, $percentage){
            if (isset($book['price'])) {
                $book['price'] += round($percentage * $book['price'], 2);
            }
        }
    }

    // using normal function
    array_walk($books, 'addTaxes', 0.16);
    var_dump($books);

    // using static class method
    array_walk($books, ['Taxes', 'add'], 0.16);
    var_dump($books);

    // using class method
    array_walk($books, [new Taxes(), 'addTaxes'], 0.16);
    var_dump($books);

    // Inheriting variables from the parent scope
    $percentage = 0.16;
    $addTaxes = function (array &$book, $index) use ($percentage) {
        if (isset($book['price'])) {$book['price'] += round($percentage * $book['price'], 2);
        }
    };

    $percentage = 100000;
    array_walk($books, $addTaxes);
    var_dump($books);

    // Inheriting variables from the parent scope and update that value
    $percentage = 0.16;
    $addTaxes = function (array &$book, $index) use (&$percentage) {
        if (isset($book['price'])) {$book['price'] += round($percentage * $book['price'], 2);
        }
    };
    array_walk($books, $addTaxes, 0.16);
    var_dump($books); $percentage = 100000;
    array_walk($books, $addTaxes, 0.16);
    var_dump($books);

