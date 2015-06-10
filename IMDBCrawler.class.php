<?php
require_once("movie.class.php");
$reader=new Crawler();
$reader->crawlRobotsFromSite("http://www.imdb.com");
$reader->crawl("http://www.imdb.com/title/tt0163025");
class Crawler
{
	//This associative array is for keeping track of the visited sites.
	public $visitedRoutes = array();	

	//Constructor
	function __construct()
	{
		
	}

	//This function will read the site's robots.txt files and try to find if there are any
	//disallowances for the crawler.
	public function crawlRobotsFromSite($siteURL)
	{
		//Finds the Robots.txt file on the site.
		$robotsURL=$siteURL."/robots.txt";
		//Opens the file and reads it line by line.
		$handle = fopen($robotsURL, "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		    	//Retrieves the first character of the line to verify if it's a comment.
		      	$comment=substr($line,0,1);
		      	if($comment!="#")
		      	{
		      		//If not a comment, it validates the disallowance.
		      		$result=$this->validateDisallow($line);
		      		if($result!=false)
		      		{
		      			//If it's a disallowance, it adds it to the visited table.
		      			$this->visitedRoutes[$result]=true;
		      		}
		      	}
			}
		    fclose($handle);
		} else {
		   //Couldn't find Robots.txt
		   error_log("Error");
		} 

	}

	//This function will validate if a sentence in the robots.txt file is a disallowance.
	private function validateDisallow($stringToEval)
	{
		//Regex matching Robots.txt policy.
		$pattern = '/Disallow: (\/[A-Za-z_?*]*)*/';
		if(preg_match($pattern,$stringToEval))
		{
			//If a match is founds, it removes the 'Disallow' word and only saves the URL
			return substr($stringToEval, 10);
		}
		return false;

	}

	//This funcion will read the page and try to find all the /title/ links available in order
	//to get other movies.
	public function getPageLinks($urlToRead)
	{
		$linksPattern='/title\/tt[0-9]*(\"|\'|\/)/';
		if(preg_match_all($linksPattern, $urlToRead,$foundLinks))
		{
			$uniqueLinks=array_unique($foundLinks[0]);
			var_dump($uniqueLinks);
		}
		
	}
	//This function will read the page and try to get the imdb id and title of the movie.
	public function crawl($urlToRead)
	{
		$urlToString=file_get_contents($urlToRead);
		$movie=new Movie($this->getMovieId($urlToString),$this->getMovieTitle($urlToString));
		$this->getPageLinks($urlToString);
		echo $movie->getTitle();
		echo $movie->getId();
		
	}

	//This function gets the movie title shown in the og:title meta property
	private function getMovieTitle($siteString)
	{
		//Regex to detect open graph title
		$pattern = '/<meta property=("|\')og:title("|\') content=(\'|").*(\'|")/';
		if(preg_match($pattern,$siteString,$foundMetaTag))
		{
			//If a match id found, we perform another comparison to obtain the title.
			$imdbTitlePattern='/content=".*"/';
			//This regex is for getting the content="" part, we need the value inside the quotes.
			preg_match($imdbTitlePattern,$foundMetaTag[0],$foundTitle);
			//Substring to remove the content=" and the final quotes.
			$imdbTitle=substr($foundTitle[0], 9);
			$imdbTitle=substr($imdbTitle,0,-1);
			//Returns the title.
			return $imdbTitle;
		}
		return false;
	}
	//This function get the movie ID shown in the og:url meta property
	private function getMovieId($siteString)
	{
		//Regex to detect open graph url (Where the Movie ID is included)
		$pattern = '/<meta property=("|\')og:url("|\') content=(\'|").*(\'|")/';
		if(preg_match($pattern,$siteString,$foundMetaTag))
		{
			//If matched, we try to obtain the id, based on a second regex
			$imdbIdPattern='/tt[0-9]+/';
			preg_match($imdbIdPattern,$foundMetaTag[0],$imdbId);
			//Return the ID
			return $imdbId[0];
		}
		return false;
	}
}
?>