<?php

    namespace Bookstore\Utils;

    use Bookstore\Exceptions\ExceededMaxAllowedException;
    use Bookstore\Exceptions\InvalidIdException;

    trait Unique {

        private static $lastID = 0;
        protected $id;

        public function setID(?int $id){
            if($id < 0)
                throw new InvalidIdException('Id can not be negative.');
            if (empty($id))
                $this->id = ++self::$lastID;
            else {
                $this->id = $id;
                if ($id > self::$lastID)
                    self::$lastID = $id;
            }
            if ($this->id > 50) {
                throw new ExceededMaxAllowedException('Max number of users is 50.');
            }
        }

        public static function getLastID(): int {
            return self::$lastID;
        }

        public function getID(): int {
            return $this->id;
        }

    }