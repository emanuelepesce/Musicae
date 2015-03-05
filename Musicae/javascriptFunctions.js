var xmlHttp;

/**
* Active Ajax 
*/
function GetXmlHttpObject(){
	var xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}catch (e){
		//Internet Explorer
		try{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}


/**
* Call php script for getting the wwekly the chart of the given genre
* 
* @param genre genre
*/
function startChart(genre){
	var xmlHttp= GetXmlHttpObject();
	
	if(xmlHttp==null){
		alert("Il tuo browser non supporta HTTP Request");
		return;
	}
	xmlHttp.onreadystatechange= function stateChanged(){
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
			document.getElementById("pescetello_div_chart").innerHTML=xmlHttp.responseText;
	}
	xmlHttp.open("GET","./src/driverFMApi.php?genre="+genre,true);
	xmlHttp.send(null);
}


/**
* Call php script for doing scraping and getting the youtube video of a song
* 
* @param artist artist of the song
* @param song name of the song
*/
function generateSong(artist,song){
	var xmlHttp= GetXmlHttpObject();
	
	if(xmlHttp==null){
		alert("Il tuo browser non supporta HTTP Request");
		return;
	}
	xmlHttp.onreadystatechange= function stateChanged(){
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
			document.getElementById("pescetello_div_song").innerHTML=xmlHttp.responseText;
	}
	xmlHttp.open("GET","./src/driverYoutube.php?string="+artist+"*del*"+song,true);
	xmlHttp.send(null);
}


/**
* Call php script for doing scraping and getting the lyrics of a song
* 
* @param artist artist of the song
* @param song name of the song
*/
function generateLyrics(artist,song){
	var xmlHttp= GetXmlHttpObject();
	if(xmlHttp==null){
		alert("Il tuo browser non supporta HTTP Request");
		return;
	}
	xmlHttp.onreadystatechange= function stateChanged(){
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
			document.getElementById("pescetello_div_lyrics").innerHTML=xmlHttp.responseText;
	}
	xmlHttp.open("GET","./src/driverLyrics.php?string="+artist+"*del*"+song,true);
	xmlHttp.send(null);
}

/**
* Write title song in the proper div
* 
* @param song name of the song
*/
function writeSongTitle(song){
	document.getElementById("pescetello_titleAlbum").innerHTML = song;
}
