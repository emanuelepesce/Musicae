<?php

include 'apiITunes.php';

$api = new iTunesAPI();

$id = $api->getIDArtist("Rihanna");
$albumsInfo = $api->getArtistAlbums($id);
$songs = $api->getSongsAlbums($albumsInfo[0][2]);

echo "ID Artist: ".$id."<br>";
echo  " <br>Artist Albums info <br>";
echo "releaseData ----- album's name ----- id collection <br>";

foreach($albumsInfo as $key=>$el){
	echo "<br>";
	#echo $key." -----";
	echo $el[0];
	echo " -----";
	echo $el[1];
	echo " -----";
	echo $el[2];
} 

echo "<br> &nbsp <br> ---- Songs ----<br>";
foreach($songs as $song){
	echo "<br>";
	echo $song;
}

?>
