<?php
  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */
  require_once "src/Genre.php";
  $server = 'mysql:host=localhost:8889;dbname=library_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class GenreTest extends PHPUnit_Framework_TestCase
  {
    protected function tearDown()
    {
      Genre::deleteSome('all');
    }

    function test_getter_setters_contructor()
    {
      //Arrange
      $genre_name = "Genre";
      $genre = new Genre('Bob');

      //Act
      $genre2 = new Genre($genre_name);
      $genre2->setGenreName($genre->getGenreName());

      //Assert
      $this->assertEquals(['Bob'], [$genre2->getGenreName()]);
    }

    function test_save()
    {
      //Arrange
      $genre_name = "An Genre";
      $genre1 = new Genre($genre_name, null);

      //Act
      $genre1->save();
      $result = Genre::getSome('all', null);

      //Assert
      $this->assertEquals([$genre1], $result);
    }

    function test_get_some_title()
    {
      //Arrange
      $genre1 = new Genre("Genre 1");
      $genre2 = new Genre("Genre 2");
      $genre3 = new Genre("Genre 3");
      $genre1->save();
      $genre2->save();
      $genre3->save();

      //Act
      $result = Genre::getSome('genre_name', "Genre 1");

      //Assert
      $this->assertEquals([$genre1], $result);
    }

    function test_delete_some_title()
    {
      //Arrange
      $genre1 = new Genre("Genre", null);
      $genre2 = new Genre("Genre", null);
      $genre3 = new Genre("Genre 3", null);
      $genre1->save();
      $genre2->save();
      $genre3->save();

      //Act
      Genre::deleteSome('genre_name', 'Genre');
      $result = Genre::getSome('all');

      //Assest
      $this->assertEquals([$genre3], $result);
    }

    function test_updateGenreName()
    {
      $genre1 = new Genre("Bob");
      $new_genre_name = 'Updated GenreName';

      $genre1->updateGenreName($new_genre_name);
      $result = $genre1->getGenreName();

      $this->assertEquals($new_genre_name, $result);
    }
  }

 ?>
