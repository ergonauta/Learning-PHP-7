<?php

    namespace Bookstore\Models;

    use Bookstore\Domain\Customer;
    use Bookstore\Domain\Customer\CustomerFactory;
    use Bookstore\Exceptions\NotFoundException;

    class CustomerModel extends AbstractModel {
        public function get(int $userId): Customer {
            $query = <<<'SQL'
SELECT * FROM customer WHERE id = :user
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->execute(['user' => $userId]);

            $row = $stmt->fetch();

            if (empty($row))
                throw new NotFoundException();

            return CustomerFactory::factory(
                $row['type'],
                $row['id'],
                $row['firstname'],
                $row['surname'],
                $row['email']
            );
        }

        public function getByEmail(string $email): Customer {
            $query = <<<'SQL'
            SELECT * FROM customer WHERE email = :email
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->execute(['user' => $email]);

            $row = $stmt->fetch();

            if (empty($row))
                throw new NotFoundException();

            return CustomerFactory::factory(
                $row['type'],
                $row['id'],
                $row['firstname'],
                $row['surname'],
                $row['email']
            );

        }
    }