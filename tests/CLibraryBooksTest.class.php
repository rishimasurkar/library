<?php

class CLibraryBooksTest extends PHPUnit\Framework\TestCase {
	private $http;

    public function setUp(): void {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/library/api/entities/libraryBooks/']);
    }

    public function testread(): void {

	    $response = $this->http->request('GET', 'getLibraryBooks.php');
	    $this->assertEquals(200, $response->getStatusCode());

	    $contentType = $response->getHeaders()["Content-Type"][0];
	    $this->assertEquals("application/json; charset=UTF-8", $contentType);

		$contents = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('records', $contents);

        $matchedArray = ["1", "Sam Newman", "Building Microservices", "9781491950357", "2021-01-10"];

        foreach($contents['records'] as $record) {
			$actualArray = array( $record['id'], $record['author'], $record['title'], $record['isbn'], $record['release_date']);
        }

        $this->assertEquals($matchedArray, $actualArray);
	}

    public function testcreate(): void {

        $dataArray = [
                        "author" => "sampleAuthor",
                        "title" => "sampleTitle",
                        "isbn" => "1234567890110",
                        "release_date" => "2020-10-20"
                    ];

        $response = $this->http->request('POST', 'createLibraryBook.php', [GuzzleHttp\RequestOptions::JSON => $dataArray]);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testcreatewithincompletedata(): void {
        $this->expectException(GuzzleHttp\Exception\ClientException::class);
        $this->expectExceptionMessage(sprintf('Cannot add book to library [Incomplete data].'));
        $this->expectExceptionCode(400);

        $dataArray = [
                        "author" => "sampleAuthor",
                        "title" => "",
                        "isbn" => "1234567890110",
                        "release_date" => "2020-10-20"
                    ];

        $response = $this->http->request('POST', 'createLibraryBook.php', [GuzzleHttp\RequestOptions::JSON => $dataArray]);
    }

	public function tearDown(): void {
        $this->http = null;
    }
}
?>