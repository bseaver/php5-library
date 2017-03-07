
<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
require_once "src/Book.php";
$server = 'mysql:host=localhost:8889;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class BookTest extends PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    Book::deleteSome('all');
  }

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

    function test_save()
    {
      //Arrange
      $title = "A Book";
      $publish_date = "2013-11-11";
      $synopsis = "It has words";
      $genre_id = 1;
      $book1 = new Book($title, $publish_date, $synopsis, $genre_id, null);

      //Act
      $book1->save();
      $result = Book::getSome('all', null);

      //Assert
      $this->assertEquals([$book1], $result);
    }

    function test_get_some_title()
    {
      //Arrange
      $publish_date = "2013-11-11";
      $synopsis = "It has words";
      $genre_id = 1;
      $book1 = new Book("Book 1", $publish_date, $synopsis, $genre_id);
      $book2 = new Book("Book 2", $publish_date, $synopsis, $genre_id);
      $book3 = new Book("Book 3", $publish_date, $synopsis, $genre_id);
      $book1->save();
      $book2->save();
      $book3->save();

      //Act
      $result = Book::getSome('title', "Book 1");

      //Assert
      $this->assertEquals([$book1], $result);
    }

    function test_delete_some_title()
    {
      //Arrange
      $publish_date = "2013-11-11";
      $synopsis = "It has words";
      $genre_id = 1;
      $book1 = new Book("Book", $publish_date, $synopsis, $genre_id);
      $book2 = new Book("Book", $publish_date, $synopsis, $genre_id);
      $book3 = new Book("Book 3", $publish_date, $synopsis, $genre_id);
      $book1->save();
      $book2->save();
      $book3->save();

      //Act
      Book::deleteSome('title', 'Book');
      $result = Book::getSome('all');

      //Assest
      $this->assertEquals([$book3], $result);
    }

    function test_updateName()
    {
      $publish_date = "2013-11-11";
      $synopsis = "It has words";
      $genre_id = 1;
      $book1 = new Book("Book", $publish_date, $synopsis, $genre_id);
      $new_name = 'Updated Name';

      $book1->updateName($new_name);
      $result = $book1->getTitle();

      $this->assertEquals($new_name, $result);

    }
    function test_updateSynopsis()
    {
      $publish_date = "2013-11-11";
      $synopsis = "It has words";
      $genre_id = 1;
      $book1 = new Book("Book", $publish_date, $synopsis, $genre_id);
      $new_synopsis = 'Updated Stuff';

      $book1->updateSynopsis($new_synopsis);
      $result = $book1->getSynopsis();

      $this->assertEquals($new_synopsis, $result);

    }
}

?>
