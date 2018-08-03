<?php

    namespace Bookstore\Models;

    use Bookstore\Domain\Book;
    use Bookstore\Exceptions\DbException;
    use Bookstore\Exceptions\NotFoundException;
    use PDO;

    class BookModel extends AbstractModel {
        const CLASSNAME = '\Bookstore\Domain\Book';

        public function get(int $bookId): Book {
            $query = <<<'SQL'
            SELECT * FROM book WHERE id = :id
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $bookId]);

            $books = $stmt->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

            if(empty($books))
                throw new NotFoundException();

            return $books[0];
        }

        public function getAll(int $page, int $pageLength): array {
            $start = $pageLength * ($page - 1);

            $query = <<<'SQL'
            SELECT * FROM book LIMIT :page, :length
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bindParam('page', $start, PDO::PARAM_INT);
            $stmt->bindParam('length', $pageLength, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }

        public function getByUser(int $userId): array {
            $query = <<<'SQL'
            SELECT b.*
FROM borrowed_books bb LEFT JOIN book b ON bb.book_id = b.id
WHERE bb.customer_id = :id
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $userId]);

            return $stmt->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }

        public function search(string $title, string $author): array {
            $query = <<<'SQL'
            SELECT * FROM book
WHERE title LIKE :title AND author LIKE :author
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bindValue('title', "%$title%");
            $stmt->bindValue('author', "%$author%");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }

        public function borrow(Book $book, int $userId) {
            $query = <<<'SQL'
            INSERT INTO borrowed_books (book_id, customer_id, start)
            VALUES (:bookId, :user, NOW()) 
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bindValue('bookId', $book->getId());
            $stmt->bindValue('user', $userId);

            if (!$stmt->execute())
                throw new DbException($stmt->errorInfo()[2]);

            $this->updateBookStock($book);
        }

        public function returnBook(Book $book, int $customerId) {
            $query = <<<'SQL'
            UPDATE borrowed_books SET end = NOW()
            WHERE book_id = :book AND customer_id = :customerId AND end IS NULL
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bindValue('book', $book->getId());
            $stmt->bindValue('customerId', $customerId);
            if (!$stmt->execute())
                throw new DbException($stmt->errorInfo()[2]);

            $this->updateBookStock($book);
        }

        private function updateBookStock(Book $book) {
            $query = <<<'SQL'
            UPDATE book 
            SET stock = :stock
            WHERE id = :id
SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bindValue('id', $book->getId());
            $stmt->bindValue('stock', $book->getStock());
            if (!$stmt->execute())
                throw new DbException($stmt->errorInfo()[2]);
        }
    }