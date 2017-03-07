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
      $author_name = "Author";
      $author = new Author('Bob');

      //Act
      $author2 = new Author($author_name);
      $author2->setAuthorName($author->getAuthorName());

      //Assert
      $this->assertEquals(['Bob'], [$author2->getAuthorName()]);
    }

    function test_save()
    {
      //Arrange
      $author_name = "An Author";
      $author1 = new Author($author_name, null);

      //Act
      $author1->save();
      $result = Author::getSome('all', null);

      //Assert
      $this->assertEquals([$author1], $result);
    }

    function test_get_some_title()
    {
      //Arrange
      $author1 = new Author("Author O'Malley 1");
      $author2 = new Author("Author 2");
      $author3 = new Author("Author 3");
      $author1->save();
      $author2->save();
      $author3->save();

      //Act
      $result = Author::getSome('author_name', "Author O'Malley 1");

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
      Author::deleteSome('author_name', 'Author');
      $result = Author::getSome('all');

      //Assest
      $this->assertEquals([$author3], $result);
    }

    function test_updateAuthorName()
    {
      $author1 = new Author("Bob");
      $author1->save();
      $new_author_name = "Updated' AuthorName";

      $author1->updateAuthorName($new_author_name);
      $results = Author::getSome('all');

      $this->assertEquals($new_author_name, $results[0]->getAuthorName());
    }
  }

 ?>
