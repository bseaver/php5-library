<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
require_once "src/Patron.php";
$server = 'mysql:host=localhost:8889;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class PatronTest extends PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    Patron::deleteSome('all');
  }

  function test_getter_setters_contructor()
  {
    //Arrange
    $name = "Patron";
    $contact_info = "None";
    $patron = new Patron('Bob', "57329485");

    //Act
    $patron2 = new Patron($name, $contact_info);
    $patron2->setName($patron->getName());
    $patron2->setContactInfo($patron->getContactInfo());

    //Assert
    $this->assertEquals(['Bob', "57329485"], [$patron2->getName(),$patron2->getContactInfo() ]);
  }

  function test_save()
  {
    //Arrange
    $name = "A Patron";
    $contact_info = "None";
    $patron1 = new Patron($name, $contact_info, null);

    //Act
    $patron1->save();
    $result = Patron::getSome('all', null);

    //Assert
    $this->assertEquals([$patron1], $result);
  }

  function test_get_some_name()
  {
    //Arrange
    $patron1 = new Patron("Patron 1", "none");
    $patron2 = new Patron("Patron 2", "none");
    $patron3 = new Patron("Patron 3", "none");
    $patron1->save();
    $patron2->save();
    $patron3->save();

    //Act
    $result = Patron::getSome('name', "Patron 1");

    //Assert
    $this->assertEquals([$patron1], $result);
  }

  function test_delete_some_name()
  {
    //Arrange
    $patron1 = new Patron("Patron", "none", null);
    $patron2 = new Patron("Patron", "none", null);
    $patron3 = new Patron("Patron 3", "none", null);
    $patron1->save();
    $patron2->save();
    $patron3->save();

    //Act
    Patron::deleteSome('name', 'Patron');
    $result = Patron::getSome('all');

    //Assest
    $this->assertEquals([$patron3], $result);
  }

  function test_updateName()
  {
    $patron1 = new Patron("Bob", "none");
    $new_name = 'Updated Name';

    $patron1->updateName($new_name);
    $result = $patron1->getName();

    $this->assertEquals($new_name, $result);
  }
}
 ?>
