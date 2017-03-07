<?php
  class Author{
    private $name;
    private $id;

    function __construct($name = '', $id = null)
    {
      $this->setName($name);
      $this->setId($id);
    }

    function setName($new_name)
    {
      $this->name = (string) $new_name;
    }

    function getName()
    {
      return $this->name;
    }

    function setId($new_id)
    {
      $this->id = (int) $new_id;
    }

    function getId()
    {
      return $this->id;
    }

    function save() {
      $GLOBALS['DB']->exec("INSERT INTO authors (name) VALUES ('{$this->getName()}');");
      $this->setId($GLOBALS['DB']->lastInsertId());
    }

    static function getSome($search_selector, $search_argument = '')
    {
        $output = array();
        $statement_handle = null;
        if ($search_selector == 'id') {
            $statement_handle = $GLOBALS['DB']->prepare(
                "SELECT * FROM authors WHERE id = :search_argument ORDER BY name, id;"
            );
            $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
        }
        if ($search_selector == 'name') {
            $statement_handle = $GLOBALS['DB']->prepare(
                "SELECT * FROM authors WHERE name = :search_argument ORDER BY name, id;"
            );
            $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
        }
        if ($search_selector == 'all') {
            $statement_handle = $GLOBALS['DB']->prepare("SELECT * FROM authors ORDER BY id;");
        }
        if ($statement_handle) {
          // var_dump($statement_handle);
            $statement_handle->execute();
            $results = $statement_handle->fetchAll();
            // $results = $GLOBALS['DB']->query($query);
            foreach ($results as $result) {
                    $new_author = new Author(
                    $result['name'],
                    $result['id']
                );
                array_push($output, $new_author);
            }
        }
        return $output;
    }

    static function deleteSome($search_selector, $search_argument = 0)
    {
        $statement_handle = null;
        if ($search_selector == 'id') {
            $statement_handle = $GLOBALS['DB']->prepare(
                "DELETE FROM authors WHERE id = :search_argument;"
            );
            $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_INT);
        }
        if ($search_selector == 'name') {
            $statement_handle = $GLOBALS['DB']->prepare(
                "DELETE FROM authors WHERE name = :search_argument;"
            );
            $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_INT);
        }
        if ($search_selector == 'all') {
            $statement_handle = $GLOBALS['DB']->prepare("DELETE FROM authors;");
        }
        if ($statement_handle) {
            $statement_handle->execute();
        }
    }

    function updateName($new_name)
    {
      $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
      $this->setName($new_name);
    }
  }

 ?>
