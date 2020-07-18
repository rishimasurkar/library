<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
require_once('../../config/CLibraryDatabase.class.php');
require_once('../CLibraryBooks.class.php');
  
$objLibraryDatabase     = new CLibraryDatabase();
$libraryDbConnection    = $objLibraryDatabase->getDbConnection();
$objLibraryBook         = new CLibraryBooks($libraryDbConnection);
  
$postData = json_decode(file_get_contents("php://input"));
  
// Validate Inputs
if(
    !empty($postData->author) &&
    !empty($postData->title) &&
    !empty($postData->isbn)
) {
  
    $objLibraryBook->author         = $postData->author;
    $objLibraryBook->title          = $postData->title;
    $objLibraryBook->isbn           = $postData->isbn;
    $objLibraryBook->release_date   = $postData->release_date;
  
    if($objLibraryBook->create()) {
        http_response_code(201);
        echo json_encode(
            array(
                    "message" => "Book added to the library!"
                )
        );

    } else {
        http_response_code(503);
        echo json_encode(
            array(
                    "message" => "Book cannot be added to the library!"
                )
        );
    }

} else {
    http_response_code(400);
    echo json_encode(
        array(
            "message" => "Cannot add book to library [Incomplete data]."
        )
    );
}
?>