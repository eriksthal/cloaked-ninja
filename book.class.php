<?php
class Book
{

private $title;
private $author;
private $language;
private $publishingDate;
private $description;
private $thumbURL;
private $isbn10;
private $isbn13;

	function __construct($title=NULL,$author=NULL,$language=NULL,$publishingDate=NULL,$description=NULL,$thumbURL=NULL,$isbn10=NULL,$isbn13=NULL)
	{
		$this->title=$title;
		$this->author=$author;
		$this->language=$language;
		$this->publishingDate=$publishingDate;
		$this->description=$description;
		$this->thumbURL=$thumbURL;
		$this->isbn13=$isbn13;
		$this->isbn10=$isbn10;
	}

	//Get the book's title
	public function getTitle(){
		return $this->title;
	}
	//Set the book's title
	public function setTitle($bookTitle){
		$this->title=$bookTitle;
		return true;
	}
	//Get the book's Author
	public function getAuthor(){
		return $this->author;
	}
	//Set the book's Author
	public function setAuthor($bookAuthor){
		$this->author=$bookAuthor;
		return true;
	}
	//Get the book's language
	public function getLanguage(){
		return $this->language;
	}
	//Set the book's language
	public function setLanguage($bookLanguage){
		$this->language=$bookLanguage;
		return true;
	}
	//Get the book's publishing date
	public function getPublishingDate(){
		return $this->publishingDate;
	}
	//Set the book's publishing date
	public function setPublishingDate($bookPublishingDate){
		$this->publishingDate=$bookPublishingDate;
		return true;
	}
	//Get the book's description
	public function getDescription()
	{
		return $this->description;
	}
	//Set the book's description
	public function setDescription($bookDescription){
		$this->description=$bookDescription;
		return true;
	}
	//Get the book's thumbnailURL
	public function getThumbURL()
	{
		return $this->thumbURL;
	}
	//Set the book's thumbnailURL
	public function setThumbURL($bookThumbURL){
		$this->thumbURL=$bookThumbURL;
		return true;
	}
	//Get book's ISBN 10
	public function getISBN10()
	{
		return $this->isbn10;
	}
	//Set book's ISBN 10
	public function setIsbn10($bookIsbn10){
		$this->isbn10=$bookIsbn10;
		return true;
	}
	//Get book's ISBN 13
	public function getISBN13()
	{
		return $this->isbn13;
	}
	//Set book's ISBN 13
	public function setIsbn13($bookIsbn13){
		$this->isbn13=$bookIsbn13;
		return true;
	}

}


?>