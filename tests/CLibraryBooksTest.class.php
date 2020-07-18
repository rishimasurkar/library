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

	public function tearDown(): void {
        $this->http = null;
    }
}
?>