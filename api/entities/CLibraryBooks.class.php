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

    public function create() {
        $query = "INSERT INTO
                    " . $this->tableName . "
                  (`author`, `title`, `isbn`, `release_date`, `created_on`, `updated_on`)
                VALUE (
                        :author, 
                        :title, 
                        :isbn, 
                        :release_date, 
                        NOW(),
                        NOW() 
                    )";
      
        $sqlPrepared = $this->connection->prepare($query);
      
        $this->author       = htmlspecialchars(strip_tags($this->author));
        $this->title        = htmlspecialchars(strip_tags($this->title));
        $this->isbn         = htmlspecialchars(strip_tags($this->isbn));
        $this->release_date = htmlspecialchars(strip_tags($this->release_date));
      
        $sqlPrepared->bindParam(":author", $this->author);
        $sqlPrepared->bindParam(":title", $this->title);
        $sqlPrepared->bindParam(":isbn", $this->isbn);
        $sqlPrepared->bindParam(":release_date", $this->release_date);
        
        if( $sqlPrepared->execute() ) {
            return true;
        }
      
        return false;
    }

    public function delete() {
      
        $query = "DELETE FROM " . $this->tableName . " WHERE id = ?";
        $sqlPrepared = $this->connection->prepare($query);
        
        $this->id=htmlspecialchars(strip_tags($this->id));
        $sqlPrepared->bindParam(1, $this->id);

        if($sqlPrepared->execute()) {
            return true;
        }
      
        return false;
    }
}
?>