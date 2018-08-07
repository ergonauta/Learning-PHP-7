<?php

    namespace Bookstore\Domain;

    interface Customer extends Payer {
        public function getMonthlyFee(): float;
        public function getAmountToBorrow(): int;
        public function getId(): int;
        public function getType(): string;
    }

