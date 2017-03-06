
<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
require_once "src/Book.php";
$server = 'mysql:host=localhost:8889;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server(), $username, $password);
class BookTest extends PHPUnit_Framework_TestCase
{
  function test_getter_setters_contructor()
  {
    //Arrange
    $title = "A Book";
    $publish_date = "2013-11-11";
    $synopsis = "It has words";
    $genre_id = 1;
    $book1 = new Book($title, $publish_date, $synopsis, $genre_id);


    //Ace
    $book2 = new Book();
    $book2->setTitle($book1->getTitle());
    $book2->setPublishDate($book1->getPublishDate());
    $book2->setSynopsis($book1->getSynopsis());
    $book2->setGenreId($book1->getGenreId());

    //Assert
    $this->assertEquals([$title, $publish_date, $synopsis, $genre_id], [$book2->getTitle(), $book2->getPublishDate(), $book2->getSynopsis(), $book2->getGenreId()]);

  }

}

?>
