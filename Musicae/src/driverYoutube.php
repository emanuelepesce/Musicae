<?php

include "scrapingYoutube.php";

/* Get parameters */
$string=$_GET['string'];

$ris=explode("*del*", $string);
$artist=$ris[0];
$song=$ris[1];

/* Get youtube video */
$yt= new scrapingYoutube();
$yt->getVideo($artist, $song);

?>
