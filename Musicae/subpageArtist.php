<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/* Get artist name */
$artist=$_GET['artist'];

include("./src/apiITunes.php");

/* Inizialize Api for gettin info about artists and id*/
$api = new iTunesAPI();
$id = $api->getIDArtist($artist);
$albumsInfo = $api->getArtistAlbums($id);
?>


<html xmlns="http://www.w3.org/1999/xhtml">
	
	<!-- Head -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Musicæ</title>
		<meta name="keywords" content="music, concerts, artists, events" />
		<meta name="description" content="All about music" />
		<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="./images/ae_logo.png"/>
	</head>
	
	<!-- Body -->
	<body>
		
		<!-- Cointainer -->
		<div id="templatemo_container">

			<div id="templatemo_header">
				<div id="templatemo_title">
					<div id="templatemo_sitetitle">Musicæ</div>
				</div>
			</div>

			<div id="templatemo_banner">
				<div id="templatemo_banner_text">
					<div id="banner_title"> Discover and explore new genres, artists and songs </div>
				</div>
			</div>
			
			<!-- Menu -->
			<div id="templatemo_menu">
				<ul>
					<li><a href="./index.html">Main Page </a></li> 
					</ul>  
			</div>
			
			<!-- Content -->
			<div id="templatemo_content">
				<div id="pescetello_div_centre">
					<h1 id="pescetello_h1">Album of <?php echo $artist; ?> </h1>
				</div> <!--chiudi pescetello_div_centre-->
				<div id="pescetello_content_inner">
				  <?php
					 /* Get albums info */
					 foreach($albumsInfo as $key=>$el){
						 echo "<div class=\"new_released_box\"><div id=\"pescetello_div_fixed\"><img class=\"myimage\"src=\"" .$el[3]. "\" alt=\"image\" style=\"max-width:200px;max-height:100px;\"  onclick=\" window.location.href='subpageAlbum.php?valore=".$artist."*del*".$el[2]."*del*".$el[1]."'\"\"><h3>".$el[1]."</h3></div></div>";
					 } 					
				?>
				</div> 
			</div> 

			<div id="templatemo_footer">
			   
				Copyrigth PesceTello
			</div>
		</div>
	</body>
</html>
