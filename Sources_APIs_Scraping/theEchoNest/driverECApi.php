<?php

include 'apiEC.php';

$api = new ecApi();

$artists = $api->getTopArtists("jazz", "15");

$photo = $api->getImgArtist("AR9PLH11187FB58A87");

echo "Top artists for genre: <br>";
foreach($artists as $key=>$el){
	echo "<br>";
	echo $key;
	echo "<br>";
	echo $el[0];
	echo "<br>";
	echo $el[1];
}
?>

