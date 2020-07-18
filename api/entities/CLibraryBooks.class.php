<?php

class CLibraryBooks{

    private $connection;
    private $tableName = "library_books";
  
    public $id;
    public $author;
    public $title;
    public $isbn;
    public $release_date;
    public $created_on;
    public $updated_on;
  
    public function __construct($database) {
        $this->connection = $database;
    }

	public function read() {
	  	$query = "SELECT * FROM " . $this->tableName . " ORDER BY id DESC";
	    $sqlPrepared = $this->connection->prepare($query);
	    $sqlPrepared->execute();
	    
	    return $sqlPrepared;
	}
}
?>