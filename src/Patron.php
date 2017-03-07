<?php
/**
 *
 */
class Patron extends Author
{
  private $contact_info;

  function __construct($name, $contact_info, $id = null)
  {
    $this->setName($name);
    $this->setContactInfo($contact_info);
    $this->setId($id);
  }

  function setContactInfo($contact_info)
  {
    $this->contact_info = $contact_info;
  }

  function getContactInfo(){
    return $this->contact_info;
  }

  function save() {
    $GLOBALS['DB']->exec("INSERT INTO patrons (name, contact_info) VALUES ('{$this->getName()}', '{$this->getContactInfo()}');");
    $this->setId($GLOBALS['DB']->lastInsertId());
  }

  static function getSome($search_selector, $search_argument = '')
  {
      $output = array();
      $statement_handle = null;
      if ($search_selector == 'id') {
          $statement_handle = $GLOBALS['DB']->prepare(
              "SELECT * FROM patrons WHERE id = :search_argument ORDER BY name, id;"
          );
          $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
      }
      if ($search_selector == 'name') {
          $statement_handle = $GLOBALS['DB']->prepare(
              "SELECT * FROM patrons WHERE name = :search_argument ORDER BY name, id;"
          );
          $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
      }
      if ($search_selector == 'contact_info') {
          $statement_handle = $GLOBALS['DB']->prepare(
              "SELECT * FROM patrons WHERE contact_info = :search_argument ORDER BY name, id;"
          );
          $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
      }
      if ($search_selector == 'all') {
          $statement_handle = $GLOBALS['DB']->prepare("SELECT * FROM patrons ORDER BY id;");
      }
      if ($statement_handle) {
        // var_dump($statement_handle);
          $statement_handle->execute();
          $results = $statement_handle->fetchAll();
          // $results = $GLOBALS['DB']->query($query);
          foreach ($results as $result) {
                  $new_patron = new Patron(
                  $result['name'],
                  $result['contact_info'],
                  $result['id']
              );
              array_push($output, $new_patron);
          }
      }
      return $output;
  }

      static function deleteSome($search_selector, $search_argument = 0)
      {
          $statement_handle = null;
          if ($search_selector == 'id') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "DELETE FROM patrons WHERE id = :search_argument;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_INT);
          }
          if ($search_selector == 'name') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "DELETE FROM patrons WHERE name = :search_argument;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_INT);
          }
          if ($search_selector == 'contact_info') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "DELETE FROM patrons WHERE contact_info = :search_argument;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_INT);
          }
          if ($search_selector == 'all') {
              $statement_handle = $GLOBALS['DB']->prepare("DELETE FROM patrons;");
          }
          if ($statement_handle) {
              $statement_handle->execute();
          }
      }
      function updateName($new_name)
      {
        $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
      }
      function updateContactInfo($new_contact_info)
      {
        $GLOBALS['DB']->exec("UPDATE patrons SET contact_info = '{$new_contact_info}' WHERE id = {$this->getId()};");
        $this->setContactInfo($new_contact_info);
      }



}





 ?>
