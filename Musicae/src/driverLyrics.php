<?php

include "scrapingLyrics.php";

$string=$_GET['string'];

$ris=explode("*del*", $string);
$artist=$ris[0];
$song=$ris[1];


$lyrics= new scrapingLyrics();

$rs = $lyrics->getSongLyrics($artist, $song);

if ($rs != -9999){ // no error in getting lyrics
	foreach ($rs as $r){
		$s = (string)$r->nodeValue ;
		if ( (strstr($s,"start of lyrics")==false) and (strstr($s, "end of lyrics")==false)) {
			if (strlen($s) <1)
				$s = "<br>";
			echo $s;
		}
	}
}

	
?>
