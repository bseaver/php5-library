<?php
  class AuthorBook
  {
    private $id;
    private $author_id;
    private $book_id;

    function __construct($author_id = null, $book_id = null, $id = null)
    {
      $this->setAuthorId($author_id);
      $this->setBookId($book_id);
      $this->setId($id);
    }

    public function getId(){
      return $this->id;
    }

    public function setId($id){
      $this->id = $id;
    }

    public function getAuthorId(){
      return $this->author_id;
    }

    public function setAuthorId($author_id){
      $this->author_id = $author_id;
    }

    public function getBookId(){
      return $this->book_id;
    }

    public function setBookId($book_id){
      $this->book_id = $book_id;
    }

    function save()
    {
      $GLOBALS['DB']->exec(
      "INSERT INTO author_book
          (author_id, book_id) VALUES
          ({$this->getAuthorId()}, {$this->getBookId()});"
      );
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getSome($search_selector, $search_argument = '')
    {
      $output = array();
      $query = "";
      if ($search_selector == 'all') {
          $query = "SELECT * FROM author_book;";
      }
      if ($search_selector == 'author_id') {
          $query = "SELECT * FROM author_book WHERE author_id = $search_argument;";
      }
      if ($search_selector == 'book_id') {
          $query = "SELECT * FROM author_book WHERE book_id = $search_argument;";
      }
      if ($query) {
          $results = $GLOBALS['DB']->query($query);
          foreach ($results as $result) {
                  $author_book = new AuthorBook(
                  $result['author_id'],
                  $result['book_id'],
                  $result['id']
              );
              array_push($output, $author_book);
          }
      }
      return $output;
    }

    static function deleteSome($search_selector, $search_argument = 0)
    {
      $delete_command = '';
      if ($search_selector == 'id') {
          $delete_command = "DELETE FROM author_book WHERE id = $search_argument;";
      }
      if ($search_selector == 'all') {
          $delete_command = "DELETE FROM author_book;";
      }
      if ($search_selector == 'author_id') {
          $delete_command = "DELETE FROM author_book WHERE author_id = $search_argument;";
      }
      if ($search_selector == 'book_id') {
          $delete_command = "DELETE FROM author_book WHERE book_id = $search_argument;";
      }
      if ($delete_command) {
          $GLOBALS['DB']->exec($delete_command);
      }
    }

    static function getAll()
    {
      return self::getSome('all');
    }

    static function deleteAll()
    {
      self::deleteSome('all');
    }
  }


?>
