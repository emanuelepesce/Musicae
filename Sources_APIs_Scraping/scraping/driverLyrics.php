<?php

include "scrapingLyrics.php";

$artist="foo fighters";
$song="walk";

$lyrics= new scrapingLyrics();
$rs = $lyrics->getSongLyrics($artist, $song);

echo "Lyrics of ".$song." by ".$artist.":<br><br>";
foreach ($rs as $r){
	$s = (string)$r->nodeValue ;
	if ( (strstr($s,"start of lyrics")==false) and (strstr($s, "end of lyrics")==false)) {
		if (strlen($s) <1)
			$s = "<br>";
		echo $s;
	}
	
}	
?>
