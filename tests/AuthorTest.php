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

  }

 ?>
