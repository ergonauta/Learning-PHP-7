<?php

    namespace Bookstore\Domain;

    class Customer {

        private $id;
        private $firstName;
        private $surname;
        private $email;
        private static $lastID = 0;

        public function __construct (
            int $id,
            string $firstName,
            string $surname,
            string $email
        ) {
            $this->setID($id);
            $this->firstName = $firstName;
            $this->surname = $surname;
            $this->email = $email;
        }

        private function setID($id) {
            if($id == null)
                $this->id = ++self::$lastID;
            else {
                $this->id = $id;
                if ($id > self::$lastID)
                    self::$lastID = $id;
            }
        }

        public function setEmailTo($email) {
            $this->email = $email;
        }

        public function getFirstName(): string {
            return $this->surname;
        }

        public function getSurname() : string {
            return $this->surname;
        }

        public function getEmail(): string {
            return $this->email;
        }

        public function getLastID(): int {
            return self::$lastID;
        }

        public function printData() : string {
            return  'First name: '  . $this->firstName .
                    ' - Surname: '   . $this->surname .
                    ' - Email: '     . $this->email;
        }

    }

