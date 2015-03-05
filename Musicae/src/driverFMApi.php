<?php

include 'apiFM.php';

$api = new fmApi();
$genre=$_GET['genre'];
$chart = $api->getChartAlbums($genre, "10");
$punto=". ";
$i=0;

foreach($chart as $el){
	$i++;
	echo "<div id=\"row_artistname\"class=\"toColor chartIndex\" onclick=\" window.location.href='subpageArtist.php?artist=".$el."'\"\"><h3 id=\"pescetello_h3\">".$i.$punto.$el."</h3> </div>";
}
?>

