<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
include("./src/scrapingYoutube.php");
include("./src/apiITunes.php");

/* Get values */
$string=$_GET['valore'];
$ris=explode("*del*",$string);
$artist=$ris[0];
$id_album=$ris[1];
$album_nome=$ris[2];

/* Inizialize class for scraping */
$you= new scrapingYoutube();
$api = new iTunesAPI();
$songs = $api->getSongsAlbums($id_album);	//array song
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
			<script src="javascriptFunctions.js" type="text/javascript"></script>	
	</head>
	
	<!-- Body -->
	<body>
		
		<!-- Container -->
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
					<li><a href="index.html">Main Page </a></li> 
				</ul>  
			</div>
			
			<!-- Content -->
			<div id="templatemo_content">
					<div id="templatemo_left_column">
					<h2>Songs</h2>
					<div class="left_col_box">
					<?php
						
						foreach($songs as $song){
							/* Clean string in order to avoid string issues*/
							$song = str_replace("'", "", $song);	
							$song = str_replace("\"", "", $song);	
							echo "<div id=\"row_songname\" class=\"toColor chartIndex\"  onclick=\"generateSong('".$artist."','".$song."');generateLyrics('".$artist."','".$song."');writeSongTitle('".$song."');\" ><h3  id=\"pescetello_song\">".$song."</h3></div>";
						}
					?>
					</div>
			   
				</div>
				
				<div id="templatemo_right_column">
				<div id="pescetello_div_centre">
					<h1 id="pescetello_h1"> Album: <?php echo $album_nome;?> </h1>
				</div> <!--chiudi pescetello_div_centre-->
				<div id="pescetello_titleAlbum">
				
				</div>
					<div id="new_released_section">
						<h1 id="pescetello_h1"></h1>
						<!-- Here youtube video and az lyrics-->
							
							<div id="pescetello_div_song"></div>
						<div id="pescetello_div_lyrics" class = "lyrics"></div>

					</div>
				</div>    
			</div> 

			<div id="templatemo_footer">
			   
				Copyrigth PesceTello
			</div>
		</div>
	</body>
</html>
