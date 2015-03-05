<?php

include 'apiFM.php';

$api = new fmApi();

$chart = $api->getChartAlbums("rock", "20");

echo "<br> ---- Chart ---- <br>";
foreach($chart as $el){
	echo "<br>";
	echo $el;
}
?>

