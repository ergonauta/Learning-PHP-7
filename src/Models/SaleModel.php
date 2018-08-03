<?php

    namespace Bookstore\Models;

    use Bookstore\Domain\Sale;
    use Bookstore\Exceptions\DbException;
    use Bookstore\Exceptions\NotFoundException;
    use PDO;

    class SaleModel extends AbstractModel {
        const CLASSNAME = '\Bookstore\Domain\Sale';

        public function getByUser(int $userId): array {
            $query = <<<'SQL'
            SELECT * FROM sale WHERE customer_id = :user
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->execute(['user' => $userId]);

            return $stmt->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }

        public function get(int $saleId): Sale {
            $query = <<<'SQL'
            SELECT * FROM sale WHERE  id = :id
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $saleId]);
            $sales = $stmt->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

            if (empty($sales))
                throw new NotFoundException('Sale not found.');
            $sale = array_pop($sales);

            $query = <<<'SQL'
            SELECT b.id, b.title, b.author, b.price, sb.amount as stock, b.isbn
            FROM sale s
            LEFT JOIN  sale_book sb ON s.id = sb.sale_id
            LEFT JOIN book b ON sb.book_id = b.id
            WHERE s.id = :id 
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $saleId]);
            $books = $stmt->fetchAll(PDO::FETCH_CLASS, BookModel::CLASSNAME);

            $sale->setBooks($books);
            return $sale;
        }

        public function create(Sale $sale) {
            $this->db->beginTransaction();

            $query = <<<'SQL'
            INSERT INTO sale(customer_id, date) 
            VALUES(:id, NOW())
SQL;
            $stmt = $this->db->prepare($query);
            if (!$stmt->execute(['id' => $sale->getCustomerId()])) {
                $this->db->rollBack();
                throw new DbException($stmt->errorInfo()[2]);
            }

            $saleId = $this->db->lastInsertId();
            $query = <<<SQL
            INSERT INTO sale_book(sale_id, book_id, amount) 
            VALUES (:sale, :book, :amount)
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bindValue('sale', $saleId);
            foreach ($sale->getBooks() as $bookId => $amount) {
                $stmt->bindValue('book', $bookId);
                $stmt->bindValue('amount', $amount);
                if (!$stmt->execute()) {
                    $this->db->rollBack();
                    throw new DbException($stmt->errorInfo()[2]);
                }
            }

            $this->db->commit();
        }

    }