<?php

    namespace Bookstore\Tests\Domain\Customer;

    use Bookstore\Domain\Sale;
    use PHPUnit\Framework\TestCase;

    class SaleTest extends TestCase {
        public function testNewSaleHasNoBooks() {
            $sale = new Sale();

            $this->assertEmpty(
                $sale->getBooks(),
                'When new, sale should have no books.'
            );
        }

        public function testAddNewBook() {
            $sale = new Sale();
            $sale->addBook(123);

            $this->assertCount(
                1,
                $sale->getBooks(),
                'Number of books not valid.'
            );

            $this->assertArrayHasKey(
                123,
                $sale->getBooks(),
                'Book id could not be found in array.'
            );

            $this->assertSame(
                $sale->getBooks()[123],
                1,
                'When not specified, amount of books is 1.'
            );

            // All three assertions can be replaced with:
            $this->assertSame(
                [123 => 1],
                $sale->getBooks(),
                'Books array does not match'
            );
        }

        public function testAddMultipleBooks() {
            $sale = new Sale();
            $sale->addBook(123,4);
            $sale->addBook(456,2);
            $sale->addBook(456,8);

            $this->assertSame(
                [123 => 4, 456 => 10],
                $sale->getBooks(),
                'Books are not as expected'
            );
        }
    }