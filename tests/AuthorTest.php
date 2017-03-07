<?php
  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */
  require_once "src/Author.php";
  $server = 'mysql:host=localhost:8889;dbname=library_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class AuthorTest extends PHPUnit_Framework_TestCase
  {
    protected function tearDown()
    {
      Author::deleteSome('all');
    }

    function test_getter_setters_contructor()
    {
      //Arrange
      $name = "Author";
      $author = new Author('Bob');

      //Act
      $author2 = new Author($name);
      $author2->setName($author->getName());

      //Assert
      $this->assertEquals(['Bob'], [$author2->getName()]);
    }

    function test_save()
    {
      //Arrange
      $name = "An Author";
      $author1 = new Author($name, null);

      //Act
      $author1->save();
      $result = Author::getSome('all', null);

      //Assert
      $this->assertEquals([$author1], $result);
    }

    function test_get_some_title()
    {
      //Arrange
      $author1 = new Author("Author 1");
      $author2 = new Author("Author 2");
      $author3 = new Author("Author 3");
      $author1->save();
      $author2->save();
      $author3->save();

      //Act
      $result = Author::getSome('name', "Author 1");

      //Assert
      $this->assertEquals([$author1], $result);
    }

    function test_delete_some_title()
    {
      //Arrange
      $author1 = new Author("Author", null);
      $author2 = new Author("Author", null);
      $author3 = new Author("Author 3", null);
      $author1->save();
      $author2->save();
      $author3->save();

      //Act
      Author::deleteSome('name', 'Author');
      $result = Author::getSome('all');

      //Assest
      $this->assertEquals([$author3], $result);
    }

    function test_updateName()
    {
      $author1 = new Author("Bob");
      $new_name = 'Updated Name';

      $author1->updateName($new_name);
      $result = $author1->getName();

      $this->assertEquals($new_name, $result);
    }
  }

 ?>
