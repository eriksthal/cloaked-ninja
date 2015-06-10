<?php

class Movie
{
	private $id;
	private $title;
	//Constructor
	function __construct($id,$title)
	{
		$this->id=$id;
		$this->title=$title;
	}
	//This function sets the movie ID
	public function setId($id){
		$this->id=$id;
		return true;
	}
	//This function gets the movie ID
	public function getId(){
		return $this->id;
	}
	//This function sets the movie Title
	public function setTitle($title){
		$this->title=$title;
		return true;
	}
	//This function gets the movie Title
	public function getTitle(){
		return $this->title;
	}

}

?>