<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
require_once('../../config/CLibraryDatabase.class.php');
require_once('../CLibraryBooks.class.php');

$objLibraryDatabase 	= new CLibraryDatabase();
$libraryDbConnection 	= $objLibraryDatabase->getDbConnection();

$objLibraryBook 		= new CLibraryBooks($libraryDbConnection);
$postData 				= json_decode(file_get_contents("php://input"));
$objLibraryBook->id 	= $postData->id;

if($objLibraryBook->delete()) {
    http_response_code(200);
    echo json_encode(
    	array(
    		"message" => "Book deleted from the library!"
    	)
    );
} else {
  	http_response_code(503);
    echo json_encode(
    	array(
    		"message" => "Failed to delete book from library!"
    	)
    );
}
?>