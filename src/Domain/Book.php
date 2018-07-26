<?php

    namespace Bookstore\Domain;

    class Book {

        private $ISBN;
        private $title;
        private $author;
        private $quantity;

        public function __construct(
            int $ISBN,
            string $title,
            string $author,
            int $quantity = 0
        ) {
            $this->ISBN = $ISBN;
            $this->title = $title;
            $this->author = $author;
            $this->quantity = $quantity;
        }

        public function setQuantityTo(int $available) {
            $this->quantity = $available;
        }

        public function getISBN() : string {
            return $this->ISBN;
        }

        public function getTitle() : string {
            return $this->title;
        }

        public function getAuthor() : string {
            return $this->author;
        }

        public function getQuantity(): int {
            return $this->quantity;
        }

        public function addCopies(int $quantity) {
            $this->quantity += $quantity;
        }

        public function getCopy() : bool {
            if ($this->isAvailable()) {
                $this->quantity--;
                return true;
            } else {
                return false;
            }
        }

        public function printData(): string {
            $result = '<i>' . $this->title
                . '</i> - ' . $this->author
                . ' - Status: ';
            if($this->isNotAvailable())
                $result .= ' <b>Not available</b>';
            else
                $result .= ' <b>Available</b>';
            return $result;
        }

        public function isNotAvailable() : bool {
            return !$this->isAvailable();
        }

        public function isAvailable(): bool {
            return $this->quantity > 1;
        }

    }