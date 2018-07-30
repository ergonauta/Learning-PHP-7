<?php

    trait Contract {
        public function sign() {
            echo "Signing the contract.";
        }
    }

    trait Communicator {
        public function sign() {
            echo "Signing to the waitress";
        }
    }

    class Manager {
        use Contract, Communicator {
            Contract::sign insteadof Communicator;
            Communicator::sign as makeASign;
        }
    }

    $manager = new Manager();
    $manager->sign(); // Signing the contract
    $manager->makeASign(); // Signing to the waitress