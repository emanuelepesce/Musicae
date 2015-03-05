<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/* Get Genre */
$genre=$_GET['genre'];

include("./src/apiEC.php");

/* For catching the notice of API limits and turn them in execptions */
set_error_handler('exceptions_error_handler');
function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
}

/* Inizialize Api*/
$api= new ecApi();

/* Get top artists, if there is an API error launch alert and go back home */
try {
	$artists = $api->getTopArtists($genre, "15");
} catch (Exception $e) {
      echo '<script type="text/javascript">'
   , 'alert("You should wait 1 minute before doing this request again"); ', 'document.location.href = "index.html";'
	
   , '</script>';
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
		
	<!-- Head -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Musicæ</title>
		<meta name="keywords" content="music, concerts, artists, events" />
		<meta name="description" content="All about music" />
		<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" type="image/png" href="./images/ae_logo.png" />

	</head>
	
	<!-- Body -->
	<body>
		
		<!-- Container -->
		<div id="templatemo_container">
			
			<!-- Header -->
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
				<div id="pescetello_div_centre">
					<h1 id="pescetello_h1"> Most Rapresentative <?php echo $genre; ?> band </h1>
				</div> <!--chiudi pescetello_div_centre-->
				<div id="pescetello_content_inner">
					<?php
					/* Get artists info */
					foreach($artists as $key=>$el)
						echo "<div class=\"new_released_box\"><div id=\"pescetello_div_fixed\"><img class=\"myimage\"src=\"" .$el[1]. "\" alt=\"image\"  style=\"max-width:200px;max-height:100px;\"  onclick=\" window.location.href='subpageArtist.php?artist=".$el[0]."'\"\"><h3>".$el[0]."</h3></div></div>";
					?>
				</div>
			</div> 

			<div id="templatemo_footer">
							   
				Copyrigth PesceTello
			</div>
		</div>
	</body>
</html>
