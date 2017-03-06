<?php
  class Author{
    private $name;

    function __construct($name = '')
    {
      $this->setName($name);
    }

    function setName($new_name)
    {
      $this->name = (string) $new_name;
    }

    function getName()
    {
      return $this->name;
    }
  }

 ?>
