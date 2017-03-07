<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
require_once "src/AuthorBook.php";
require_once "src/Author.php";
require_once "src/Book.php";
$server = 'mysql:host=localhost:8889;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class AuthorBookTest extends PHPUnit_Framework_TestCase
{
  function test_AuthorBook_get_set_construct()
  {
    // Arrange
    $author_book1 = new AuthorBook(2, 1);
    // Act
    $author_book2 = new AuthorBook(3, 7);
    $author_book2->setAuthorId($author_book1->getAuthorId());
    $author_book2->setBookId($author_book1->getBookId());
    // Assert
    $this->assertEquals(
        [2, 1],
        [$author_book2->getAuthorId(), $author_book2->getBookId()]
    );
  }

  function test_BrandStore_save_deleteAll_getAll()
  {
    // Arrange
    $author_book1 = new AuthorBook(2, 1);
    $author_book2 = new AuthorBook(3, 7);
    // Act
    $author_book1->save();
    $author_book2->save();
    AuthorBook::deleteAll();
    $author_book3 = new AuthorBook(11, 22);
    $author_book4 = new AuthorBook(14, 33);
    $author_book3->save();
    $author_book4->save();
    // Assert
    $this->assertEquals(
        [$author_book3, $author_book4],
        AuthorBook::getAll()
    );
  }
}

?>
