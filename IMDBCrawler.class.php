<?php
$reader=new MoviesCrawler();
$reader->crawlRobotsFromSite("http://www.amazon.com/robots.txt");
$reader->crawlForTitleAndId("http://www.imdb.com/title/tt0163025/?ref_=tt_rec_tti");
class MoviesCrawler
{
	public $forbiddenRoutes = array();	
	function __construct()
	{
		
	}
	public function crawlRobotsFromSite($robotsURL)
	{
		$handle = fopen($robotsURL, "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		      	$comment=substr($line,0,1);
		      	if($comment!="#")
		      	{
		      		$result=$this->validateDisallow($line);
		      		if($result!=false)
		      		{
		      			array_push($this->forbiddenRoutes,$result);
		      		}
		      	}
			}
		    fclose($handle);
		} else {
		   error_log("Error");
		} 

	}

	private function validateDisallow($stringToEval)
	{
		$pattern = '/Disallow: (\/[A-Za-z_?*]*)*/';
		if(preg_match($pattern,$stringToEval))
		{
			return substr($stringToEval, 10);
		}
		return false;

	}

	public function crawlForTitleAndId($urlToCrawl)
	{
		$siteOnAString=file_get_contents($urlToCrawl);
		echo "MovieId: ".$this->getMovieId($siteOnAString);
		echo "MovieTitle: ".$this->getMovieTitle($siteOnAString);
		
	}
	private function getMovieTitle($siteString)
	{
		$pattern = '/<meta property=("|\')og:title("|\') content=(\'|").*(\'|")/';
		if(preg_match($pattern,$siteString,$foundMetaTag))
		{
			$imdbTitlePattern='/content=".*"/';
			preg_match($imdbTitlePattern,$foundMetaTag[0],$foundTitle);
			$imdbTitle=substr($foundTitle[0], 9,strlen($foundTitle)-1);
			return $imdbTitle;
		}
		return false;
	}
	private function getMovieId($siteString)
	{
		$pattern = '/<meta property=("|\')og:url("|\') content=(\'|").*(\'|")/';
		if(preg_match($pattern,$siteString,$foundMetaTag))
		{
			$imdbIdPattern='/tt[0-9]+/';
			preg_match($imdbIdPattern,$foundMetaTag[0],$imdbId);
			return $imdbId[0];
		}
		return false;
	}
}
?>