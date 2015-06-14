<?php
require_once("book.class.php");
$jsonFile = file_get_contents("dummyresponse.json");
$parser=new GoogleBooksParser();
$parser->getBookInformation($jsonFile);
var_dump($parser->getParsedBooks());

class GoogleBooksParser 
{
	public $parsedBooks=array();
	function __construct()
	{

	}
	public function getParsedBooks()
	{
		return $this->parsedBooks;
	}

	private function pushBook($book)
	{
		//Try to get the book into de array
		try{
			array_push($this->parsedBooks,$book);
			return true;
		}
		//If pushed fails, log error and return false.
		catch(Exception $e){
			error_log("Could not insert book in array. ".$e);
			return false;
		}
	}
	public function getBookInformation($jsonResponse)
	{
		//Decode de JSON response
		$bookObjects=json_decode($jsonResponse,true);
		//Get the number of books in the JSON file
		$totalBooks=$bookObjects['totalItems'];
		//Iterate through the current number of books
		for($i=0;$i<$totalBooks;$i++)
		{
			$book=new Book();
			//Get book's title and save it to object
			$book->setTitle($bookObjects['items'][$i]['volumeInfo']['title']);
			//Get book's first Author (Secondary ones are mainly translators) and save it to object
			$book->setAuthor($bookObjects['items'][$i]['volumeInfo']['authors'][0]);
			//Get book's Language and save it to object
			$book->setLanguage($bookObjects['items'][$i]['volumeInfo']['language']);
			//Get book's publication date and save it to object
			$book->setPublishingDate($bookObjects['items'][$i]['volumeInfo']['publishedDate']);
			//Get book's description and save it to object
			$book->setDescription($bookObjects['items'][$i]['volumeInfo']['description']);
			//Get book's thumbnail URL and save it to object
			$book->setThumbURL($bookObjects['items'][$i]['volumeInfo']['imageLinks']['thumbnail']);
			//Iterate through the industry identifiers to get the ISBN
			foreach ($bookObjects['items'][$i]['volumeInfo']['industryIdentifiers'] as $key)
				{
					switch($key["type"])
					{
						//If identifier type is ISBN 10
						case "ISBN_10":
						$book->setIsbn10($key["identifier"]);
						break;
						//IF identifier type is ISBN 13
						case "ISBN_13":
						$book->setIsbn13($key["identifier"]);
						break;
					}
				}
			echo "<img src='".$book->getThumbURL()."'><br>";
			echo "Title: ".$book->getTitle()."</br>";
			echo "Author: ".$book->getAuthor()."</br>";
			echo "Language: ".$book->getLanguage()."</br>";
			echo "Publishing Year: ".$book->getPublishingDate()."</br>";
			echo "Description: ".$book->getDescription()."</br>";
			echo "ISBN 10: ".$book->getIsbn10()."</br>";
			echo "ISBN 13: ".$book->getIsbn13()."</br>";
			//Push book to general book array
			$this->pushBook($book);
		}
	}
}
?>