# library API

## Tech Stack
Language		: PHP 7.2
Database 		: Mysql 5.7 
Unit Test FW 	: PHPUnit 8.5.8
HTTP Client 	: Guzzle 7.0
GitHub 			: https://github.com/rishimasurkar/library 
Host 			: AWS [free teir]
Host URL 		: http://ec2-54-82-200-16.compute-1.amazonaws.com


The Library API contains the following endpoints.

1. READ 
	EndPoint - getLibraryBooks.php
	URL - http://ec2-54-82-200-16.compute-1.amazonaws.com/library/api/entities/libraryBooks/getLibraryBooks.php
	Content Type - application/json
	Input - NA
	Output - 
	{
	    "records": [
	        {
	            "id": "3",
	            "author": "AWS API",
	            "title": "AWS Host Library API",
	            "isbn": "3333-2222-454-44",
	            "release_date": "2020-07-18"
	        },
	        {
	            "id": "2",
	            "author": "Amit Shah Aurobindo Sarkar",
	            "title": "Learning Aws - Second Edition",
	            "isbn": "978-1787281066",
	            "release_date": "2019-05-22"
	        },
	        {
	            "id": "1",
	            "author": "Sam Newman",
	            "title": "Building Microservices",
	            "isbn": "9781491950357",
	            "release_date": "2021-01-10"
	        }
	    ]
	}

2. CREATE 
	EndPoint - createLibraryBook.php
	URL - http://ec2-54-82-200-16.compute-1.amazonaws.com/library/api/entities/libraryBooks/createLibraryBook.php
	Content Type - application/json
	Input - 
		{
		    "author" : "AWS API",
		    "title" : "AWS Host Library API",
		    "isbn" : "3333-2222-454-44",
		    "release_date" : "2020-07-18"
		}
	Output - 
		{
		    "message": "Book added to the library!"
		}

3. DELETE [
	EndPoint - deleteLibraryBook.php
	URL - http://ec2-54-82-200-16.compute-1.amazonaws.com/library/api/entities/libraryBooks/deleteLibraryBook.php
	Content Type - application/json
	Input - 
		{
		    "id" : "1"
		}
	Output - 
		{
		    "message": "Book deleted from the library!"
		}