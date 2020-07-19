<?php

class CLibraryBooksTest extends PHPUnit\Framework\TestCase {
	private $http;
    private $connection = null;
    private $tableName  = "library_books";

    public function setUp(): void {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/library/api/entities/libraryBooks/']);
        $this->connection = new PDO("mysql:host=localhost;dbname=" . $GLOBALS['DB_NAME'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
    }

    public function testread(): void {

        $response = $this->getCreateBookSample();

	    $response = $this->http->request('GET', 'getLibraryBooks.php');
	    $this->assertEquals(200, $response->getStatusCode());

	    $contentType = $response->getHeaders()["Content-Type"][0];
	    $this->assertEquals("application/json; charset=UTF-8", $contentType);

		$contents = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('records', $contents);

        $matchedArray = ["sampleAuthor", "sampleTitle", "1234567890110", "2020-10-20"];
		$actualArray = array( $contents['records'][0]['author'], $contents['records'][0]['title'], $contents['records'][0]['isbn'], $contents['records'][0]['release_date']);

        $this->assertEquals($matchedArray, $actualArray);
	}

    public function testcreate(): void {

        $response = $this->getCreateBookSample();
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testcreatewithincompletedata(): void {
        $this->expectException(GuzzleHttp\Exception\ClientException::class);
        $this->expectExceptionMessage(sprintf('Cannot add book to library [Incomplete data].'));
        $this->expectExceptionCode(400);

        $dataArray = [
                        "author" => "sampleAuthor",
                        "title" => "sampleTitle",
                        "isbn" => "",
                        "release_date" => "2020-10-20"
                    ];

        $response = $this->http->request('POST', 'createLibraryBook.php', [GuzzleHttp\RequestOptions::JSON => $dataArray]);
    }

    public function testdelete(): void {
        // Create a test book.
        $response = $this->getCreateBookSample();
        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->http->request('GET', 'getLibraryBooks.php');
        $contents = json_decode($response->getBody()->getContents(), true);
        $dataArray = ["id" => $contents['records'][0]['id']];

        $response = $this->http->request('POST', 'deleteLibraryBook.php', [GuzzleHttp\RequestOptions::JSON => $dataArray]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    private function getCreateBookSample() {
        $dataArray = [
                        "author" => "sampleAuthor",
                        "title" => "sampleTitle",
                        "isbn" => "1234567890110",
                        "release_date" => "2020-10-20"
                    ];

        $response = $this->http->request('POST', 'createLibraryBook.php', [GuzzleHttp\RequestOptions::JSON => $dataArray]);

        return $response;
    }

	public function tearDown(): void {

        $query = "DELETE FROM " . $this->tableName . " WHERE author = 'sampleAuthor'";
        $sqlPrepared = $this->connection->prepare($query);
        $sqlPrepared->execute();
        
        $this->http = null;
    }
}
?>