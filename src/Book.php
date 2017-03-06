<?php
  class Book
  {
      private $title;
      private $publish_date;
      private $synopsis;
      private $genre_id;
      private $id;

      function __construct($title = '', $publish_date = '', $synopsis = '', $genre_id = null, $id = null)
      {
        $this->setTitle($title);
        $this->setPublishDate($publish_date);
        $this->setSynopsis($synopsis);
        $this->setGenreId($genre_id);
        $this->setId($id);
      }

      public function getTitle(){
    		return $this->title;
    	}

    	public function setTitle($title){
    		$this->title = $title;
    	}

    	public function getPublishDate(){
    		return $this->publish_date;
    	}

    	public function setPublishDate($publish_date){
    		$this->publish_date = $publish_date;
    	}

    	public function getSynopsis(){
    		return $this->synopsis;
    	}

    	public function setSynopsis($synopsis){
    		$this->synopsis = $synopsis;
    	}

    	public function getGenreId(){
    		return $this->genre_id;
    	}

    	public function setGenreId($genre_id){
    		$this->genre_id = $genre_id;
    	}

    	public function getId(){
    		return $this->id;
    	}

    	public function setId($id){
    		$this->id = $id;
    	}

      function save() {
        $GLOBALS['DB']->exec("INSERT INTO books (title, publish_date, synopsis, genre_id) VALUES ('{$this->getTitle()}', '{$this->getPublishDate()}', '{$this->getSynopsis()}', {$this->getGenreId()});");
        $this->setId($GLOBALS['DB']->lastInsertId());
      }

      static function getSome($search_selector, $search_argument = '')
      {
          $output = array();
          $statement_handle = null;
          if ($search_selector == 'id') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "SELECT * FROM books WHERE id = :search_argument ORDER BY title, id;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
          }
          if ($search_selector == 'title') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "SELECT * FROM books WHERE title = :search_argument ORDER BY title, id;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
          }
          if ($search_selector == 'publish_date') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "SELECT * FROM books WHERE publish_date = :search_argument ORDER BY name, id;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
          }
          if ($search_selector == 'genre_id') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "SELECT * FROM books WHERE genre_id = :search_argument ORDER BY name, id;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_STR);
          }
          if ($search_selector == 'all') {
              $statement_handle = $GLOBALS['DB']->prepare("SELECT * FROM books ORDER BY id;");
          }
          if ($statement_handle) {
            // var_dump($statement_handle);
              $statement_handle->execute();
              $results = $statement_handle->fetchAll();
              // $results = $GLOBALS['DB']->query($query);
              foreach ($results as $result) {
                      $new_book = new Book(
                      $result['title'],
                      $result['publish_date'],
                      $result['synopsis'],
                      $result['genre_id'],
                      $result['id']
                  );
                  array_push($output, $new_book);
              }
          }
          return $output;
      }

      static function deleteSome($search_selector, $search_argument = 0)
      {
          $statement_handle = null;
          if ($search_selector == 'id') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "DELETE FROM books WHERE id = :search_argument;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_INT);
          }
          if ($search_selector == 'title') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "DELETE FROM books WHERE title = :search_argument;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_INT);
          }
          if ($search_selector == 'genre_id') {
              $statement_handle = $GLOBALS['DB']->prepare(
                  "DELETE FROM books WHERE genre_id = :search_argument;"
              );
              $statement_handle->bindValue(':search_argument', $search_argument, PDO::PARAM_INT);
          }
          if ($search_selector == 'all') {
              $statement_handle = $GLOBALS['DB']->prepare("DELETE FROM books;");
          }
          if ($statement_handle) {
              $statement_handle->execute();
          }
      }

  }
?>
