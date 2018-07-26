<?php

    namespace Bookstore\Domain;

    class Person {

        private static $lastID = 0;
        protected $id;
        protected $firstName;
        protected $surname;
        protected $email;

        public function __construct(
            int $id,
            string $firstName,
            string $surname,
            string $email
        ) {
            $this->firstName = $firstName;
            $this->surname = $surname;
            $this->email = $email;
            $this->setID($id);
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

        public function getFirstName() : string {
            return $this->firstName;
        }

        public function getSurname() : string {
            return $this->surname;
        }

        public function getEmail(): string {
            return $this->email;
        }

        public function setEmailTo($email) {
            $this->email = $email;
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