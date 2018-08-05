<?php

    namespace Bookstore\Tests\Domain\Customer;

    use Bookstore\Domain\Customer;
    use Bookstore\Domain\Customer\CustomerFactory;
    use Bookstore\Domain\Customer\Basic;
    use PHPUnit\Framework\TestCase;

    class CustomerFactoryTest extends TestCase {
        public function testFactoryBasic() {
            $customer = CustomerFactory::factory('basic', 1, 'han', 'solo', 'han@gmail.com');

            $this->assertInstanceOf(
                Basic::class,
                $customer,
                'Basic should create a Customer\Basic object.'
            );

            $expectedBasicCustomer = new Basic(1, 'han', 'solo', 'han@gmail.com');

            $this->assertEquals(
                $customer,
                $expectedBasicCustomer,
                'Customer object is not as expected'
            );
        }

        /**
         * @expectedException \InvalidArgumentException
         * @expectedExceptionMessage  Wrong type.
         */
        public function testCreatingWrongTypeOfCustomer() {
            $customer = CustomerFactory::factory('deluxe', 1, 'han', 'solo', 'han@gmail.com');
        }

        /**
         * @expectedException \ InvalidArgumentException
         */
        public function testCreatingCorrectCustomer() {
            $customer = CustomerFactory::factory('basic',1,'han','solo','han@gmail.com');
        }
    }