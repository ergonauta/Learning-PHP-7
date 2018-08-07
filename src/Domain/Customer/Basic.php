<?php

    namespace Bookstore\Domain\Customer;

    use Bookstore\Domain\Customer;
    use Bookstore\Domain\Person;

    class Basic extends Person implements Customer {

        public function getMonthlyFee(): float {
            return 5.0;
        }

        public function getAmountToBorrow(): int {
            return 3;
        }

        public function getType(): string {
            return 'Basic';
        }

        public function getId(): int {
            return $this->id;
        }

        public function pay(float $amount) {
            echo "Paying $amount.";
        }

        public function isExtentOfTaxes(): bool {
            return false;
        }

    }