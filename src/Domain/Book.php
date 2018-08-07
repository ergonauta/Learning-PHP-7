<?php

    namespace Bookstore\Domain;

    class Book {

        private $id;
        private $isbn;
        private $title;
        private $author;
        private $stock;
        private $price;

        public function getId(): int {
            return $this->id;
        }

        public function getIsbn() : string {
            return $this->isbn;
        }

        public function getTitle() : string {
            return $this->title;
        }

        public function getAuthor() : string {
            return $this->author;
        }

        public function getStock(): int {
            return $this->stock;
        }

        public function getCopy() : bool {
            if ($this->isAvailable()) {
                $this->stock--;
                return true;
            } else {
                return false;
            }
        }

        public function getPrice(): float {
            return $this->price;
        }

        public function addCopy() {
            $this->stock++;
        }

        public function isNotAvailable() : bool {
            return !$this->isAvailable();
        }

        public function isAvailable(): bool {
            return $this->stock > 0;
        }

    }