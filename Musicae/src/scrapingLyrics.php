<?php
include "libDOM.php";

/*
 * Scraping on AZlyrics
 */
class scrapingLyrics{

    /**
	* Constructor
	*/
    public function __construct(){            
    } 
	
	/**
	* Return the lyrics of $song by $artist
	*
	* @param string $song name of the song
	* @param string $artist name of the artist
	*
	* @return list $lyrics list of lyrics, each element contais a part of lyrics of the song
						   i.e.: foreach ($lyrics as $lyric) echo $lyric->nodeValue;
	*/	
	public function getSongLyrics($artist,$song){
		/* preprocessing paramters */
		$artist=strtolower($artist);
		$song=strtolower($song);
		$artist= str_replace(" ","",$artist);
        $song = str_replace(" ","",$song);
        
        /* Build up url */
        $url = "http://www.azlyrics.com/lyrics/".$artist."/".$song.".html";
		
		/* Get DOM */
        $dom = new libDOM();
#		$xPath = $dom->getDOM($url);
		
		$lyrics = -9999;
		
		try {
			$xPath = $dom->getDOM($url);
			
			/* Do query */
        	$query = "//body/div[@style]/child::node()";
			$lyrics = $xPath->query($query);	
		
		}catch (Exception $e) {
    		echo " ";
    	}
		
		return($lyrics);
	}
}
?>
