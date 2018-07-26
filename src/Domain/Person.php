<?php

    namespace Bookstore\Domain;

    class Person {

        protected $firstName;
        protected $surname;

        public function __construct(string $firstName, string $surname) {
            $this->firstName = $firstName;
            $this->surname = $surname;
        }

        public function getFirstName() : string {
            return $this->firstName;
        }

        public function getSurname() : string {
            return $this->surname;
        }

    }