<?php

    namespace Bookstore\Utils;

    trait Unique {

        protected $id;

        public function setID(int $id){
            $this->id = $id;
        }

        public function getID(): int {
            return $this->id;
        }

    }