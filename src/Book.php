<?php
  class Book
  {
      private $title;
      private $publish_date;
      private $synopsis;
      private $genre_id;
      private $id;

      function __construct($title = '', $publish_date, $synopsis = '', $genre_id = null, $id = null)
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
  }
?>
