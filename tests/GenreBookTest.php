<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
require_once "src/GenreBook.php";
require_once "src/Genre.php";
require_once "src/Book.php";
$server = 'mysql:host=localhost:8889;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class GenreBookTest extends PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    GenreBook::deleteSome('all');
  }

  function test_GenreBook_get_set_construct()
  {
    // Arrange
    $genre_book1 = new GenreBook(2, 1);
    // Act
    $genre_book2 = new GenreBook(3, 7);
    $genre_book2->setGenreId($genre_book1->getGenreId());
    $genre_book2->setBookId($genre_book1->getBookId());
    // Assert
    $this->assertEquals(
        [2, 1],
        [$genre_book2->getGenreId(), $genre_book2->getBookId()]
    );
  }

  function test_BrandStore_save_deleteAll_getAll()
  {
    // Arrange
    $genre_book1 = new GenreBook(2, 1);
    $genre_book2 = new GenreBook(3, 7);
    // Act
    $genre_book1->save();
    $genre_book2->save();
    GenreBook::deleteAll();
    $genre_book3 = new GenreBook(11, 22);
    $genre_book4 = new GenreBook(14, 33);
    $genre_book3->save();
    $genre_book4->save();
    // Assert
    $this->assertEquals(
        [$genre_book3, $genre_book4],
        GenreBook::getAll()
    );
  }

  function test_GenreBook_update()
  {
    // Arrange
    $genre_book1 = new GenreBook(2, 1);
    $genre_book1->save();
    // Act
    $genre_book1->update(33, 37);
    $genre_books = GenreBook::getSome('all');
    $genre_book2 = $genre_books[0];
    // Assert
    $this->assertEquals(
        [33, 37],
        [$genre_book2->getGenreId(), $genre_book2->getBookId()]
    );
  }

}

?>
