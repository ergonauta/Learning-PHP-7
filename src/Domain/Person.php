<?php

    namespace Bookstore\Domain;

    use Bookstore\Utils\Unique;

    class Person {
        use Unique;

        protected $firstName;
        protected $surname;
        protected $email;

        public function __construct(
            ?int $id,
            string $firstName,
            string $surname,
            string $email
        ) {
            $this->firstName = $firstName;
            $this->surname = $surname;
            $this->email = $email;
            $this->setID($id);
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

        public function printData() : string {
            return  'First name: '  . $this->firstName .
                ' - Surname: '   . $this->surname .
                ' - Email: '     . $this->email;
        }

    }