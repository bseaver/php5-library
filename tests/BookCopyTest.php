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
            BookCopy::deleteSome('all');
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

        function test_BookCopy_save_deleteSome_all_getSome_all()
        {
            // Arrange
            $bookcopy1 = new BookCopy(2, 1, 'checked out');
            $bookcopy2 = new BookCopy(2, 1, "check's out");

            // Act
            $bookcopy1->save();
            $bookcopy2->save();

            BookCopy::deleteSome('all');

            $bookcopy3 = new BookCopy(4, 4, "check's out");
            $bookcopy4 = new BookCopy(4, 3, 'checked out');
            $bookcopy3->save();
            $bookcopy4->save();

            // Assert
            $this->assertEquals(
                [$bookcopy3, $bookcopy4],
                BookCopy::getSome('all')
            );
        }

        function test_BookCopy_update()
        {
            // Arrange
            $bookcopy1 = new BookCopy(2, 1, 'checked out');
            $bookcopy2 = new BookCopy(2, 1, "check's out");
            $bookcopy1->save();
            $bookcopy2->save();

            // Act
            $bookcopy1->update($bookcopy1->getBookId(), 4, "'hello'");
            $result = BookCopy::getSome('all');

            // Assert
            $this->assertEquals([$bookcopy1, $bookcopy2], $result);
            $this->assertEquals(2, $result[0]->getBookId());
            $this->assertEquals(4, $result[0]->getBookCondition());
            $this->assertEquals("'hello'", $result[0]->getComment());
        }
    }
?>
