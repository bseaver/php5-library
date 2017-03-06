<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/BookCopy.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $user = 'root';
    $password = 'root';
    $DB = new PDO($server, $user, $password);

    class BookCopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // BookCopy::deleteSome('all');
        }

        function test_BookCopy_get_set_construct()
        {
            // Arrange
            $book_copy1 = new BookCopy(1, 3, 'lost');

            // Act
            $book_copy2 = new BookCopy(2, 1, 'checked out');
            $book_copy2->setBookId($book_copy1->getBookId());
            $book_copy2->setBookCondition($book_copy1->getBookCondition());
            $book_copy2->setComment($book_copy1->getComment());

            // Assert
            $this->assertEquals(
                [1, 3, 'lost'],
                [$book_copy2->getBookId(),
                $book_copy2->getBookCondition(),
                $book_copy2->getComment()]
            );
        }
    }
?>
