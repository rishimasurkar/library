<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/CLibraryDatabase.class.php');
require_once('../CLibraryBooks.class.php');

$objLibraryDatabase 	= new CLibraryDatabase();
$libraryDbConnection 	= $objLibraryDatabase->getDbConnection();

$objLibraryBooks 		= new CLibraryBooks($libraryDbConnection);

$queryStatement 		= $objLibraryBooks->read();
$rowCount 				= $queryStatement->rowCount();

// check if more than 0 record found
if($rowCount>0) {
  
    $libraryBooks=array();
    $libraryBooks["records"]=array();
  
    while ($row = $queryStatement->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
  
        $libraryContents=array(
            "id" 			=> $id,
            "author" 		=> $author,
            "title" 		=> $title,
            "isbn" 			=> $isbn,
            "release_date" 	=> $release_date
        );
  
        array_push($libraryBooks["records"], $libraryContents);
    }

    http_response_code(200);
  
    echo json_encode($libraryBooks);

} else {

    http_response_code(404);
  
    echo json_encode(
        array("message" => "Sorry! no books can be found.")
    );
}
?>