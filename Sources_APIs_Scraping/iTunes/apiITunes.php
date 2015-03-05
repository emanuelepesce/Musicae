<?php
/*
 * iTunes API
 */
class iTunesAPI{
	
	private $key; // iTunes user key
	private $limitArt; // limit of elements to take when an artist is searched
	
	/* ============= Constructors ============= */
	
	/**
	* Default constructor 
	* key is not required by iTunes
	* 
	* @return void
	*/
	public function __construct(){
		$this -> limitArt = "15";
	}
	
	/* ============= Public Methods ============= */
	
	/**
	* Get the iTunes artistId by name
	*
	* @param string $artist name of the artist
	*
	* @return int $id artist id; if is > 0 it's ok, else it return -9999 in case of error
	*/
	public function getIDArtist($artist){	
		
		/* Build up URL */
		$artist = strtolower($artist); // it needs lower case
		$service_url = $this->urlArtist($artist);

		/* API request using curl */
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
	
		if ($curl_response === false) {	// API error 
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		
		/* Decode json to php */
		$decoded = json_decode($curl_response);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
			die('error occured: ' . $decoded->response->errormessage);
		}
		

		/* Get artist ID */
		/* Make sure to get correct information */
		$match = -1;
		$i = 0;
		while ( ($i<($this->limitArt)) and ($match<0) ){	
			$nameCur = $decoded->results[$i]->artistName;
			if (strlen($artist) == strlen($nameCur)){	// if lengths are equal
				if (strcmp($artist, $nameCur) > 0){		// if names are equal
					$match = $i;						// save the id because it's correct
				}
			}
			$i++;
						
		}
		
		if ($match < 0){	// error, artist not found
			$id = -9999;
		}
		else{				// all right, take artistId
			$id = $decoded->results[$match]->artistId;
		}
		
		return $id;
	} // end getIDArtist



	/**
	* Get the albums info of an artist
	* Get all the albums
	* For each album: release data, album name, id album;
	*
	* @param string $id artist ID 
	*
	* @return array $albumsInfo it's like a dictionary with multiple values.
	*							Each element is so composed: releaseData => array(nameAlbum, idAlbum);
	*/
	public function getArtistAlbums($id){	
		
		/* Build up URL */
		$service_url = $this->urlAlbums($id);
		/* API request using curl */
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
	
		if ($curl_response === false) {	// API error 
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
	
		/* Decode json to php */
		$decoded = json_decode($curl_response);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
			die('error occured: ' . $decoded->response->errormessage);
		}

		/* Get artist Albums */
		/* Get albums info: name, release date and id */
		$numAlbums = count($decoded->results);
		$albums = array();
		$releaseDate = array();
		$albumsIDs = array();
		$artworks = array();
#		for ($i = 1; $i < $numAlbums; $i++){
#			$albums[$i-1] = $decoded->results[$i]->collectionName;
#			$releaseDate[$i-1] = $decoded->results[$i]->releaseDate;
#			$albumsIDs[$i-1] = $decoded->results[$i]->collectionId;
#			$artworks[$i-1] = $decoded->results[$i]->artworkUrl100;
#		}
		
		/* Put songs in an array removing songs with the same name*/
		$j=0;
		for ($i = 1; $i < $numAlbums; $i++){
			$cur = $decoded->results[$i]->collectionName;
			$found = false;
			$k=0;
			while ($k<$j and $found==false){

				if ($cur === $albums[$k]){
					$found = true;
				}
				$k++;
			}
			if ($found == false){
#				$songs[$j] = $cur;
				$albums[$j] = $decoded->results[$i]->collectionName;
				$releaseDate[$j] = $decoded->results[$i]->releaseDate;
				$albumsIDs[$j] = $decoded->results[$i]->collectionId;
				$artworks[$j] = $decoded->results[$i]->artworkUrl100;
				$j++;
			}
		}
		/* Because after it use numAlbums-1, and $j is the length of elements included in the lists */
		/* So now j stands for the number of albums taken*/
		$numAlbums = $j+1;
		
		
		
		array_multisort($releaseDate, SORT_DESC, SORT_STRING, $albums, $albumsIDs, $artworks);
		
		/* Build up a structure with all the information
		 * Key -> (value1, value2)
		 * data -> (albumName, idAlbums) 
		 */
		$arr = array('date','album', 'id', 'art');
		$albumsInfo = array_fill(0, $numAlbums-1, $arr);	// inizialize structure

		/* Fill structure*/
		$i=0;
		foreach($albumsInfo as $key=>$el){
			$albumsInfo[$key] = array($releaseDate[$i], $albums[$i], $albumsIDs[$i], $artworks[$i]); 
			$i++;
		}
		

		return($albumsInfo);
	} // end getArtistAlbums
	
	
	
	/**
	* Get the songs of an albums
	*
	* @param string $id album ID 
	*
	* @return array $songs array with the songs of the album
	*/
	public function getSongsAlbums($id){	
		
		/* Build up URL */
		$service_url = $this->urlSongs($id);

		/* API request using curl */
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
	
		if ($curl_response === false) {	// API error 
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
	
		/* Decode json to php */
		$decoded = json_decode($curl_response);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
			die('error occured: ' . $decoded->response->errormessage);
		}
		
		$numSongs = count($decoded->results);

#		Previous
#		$songs = array();
#		for ($i = 1; $i < $numSongs; $i++){
#			$songs[$i-1] = $decoded->results[$i]->trackName;
#		}

		/* Put songs in an array removing songs with the same name*/
		$j=0;
		for ($i = 1; $i < $numSongs; $i++){
			$cur = $decoded->results[$i]->trackName;
			$found = false;
			$k=0;
			while ($k<$j and $found==false){

				if ($cur === $songs[$k]){
					$found = true;
				}
				$k++;
			}
			if ($found == false){
				$songs[$j] = $cur;
				$j++;
			}
		}
		
		return($songs);
	} // end getSongsAlbums
	
	
	
	
	/* ============= Private Methods ============= */
	
	/**
	* Build up url for getting artist info by name.
	*
	* @param string $artist name of the artist
	*
	* @return string $url url ready for making the request to iTunes API
	*/
	private function urlArtist($artist){
		$url = "https://itunes.apple.com/search?term=".$artist."&limit=".$this->limitArt; 
		$url = str_replace(' ', '+', $url);
		return($url);
	}
	
	
	/**
	* Build up url for getting artist albums by ID.
	*
	* @param string $artistID id of the artist
	*
	* @return string $url url ready for making the request to iTunes API
	*/
	private function urlAlbums($artistId){
		$url = "https://itunes.apple.com/lookup?id=".$artistId."&entity=album"; 
		return($url);
	}
	
	
	
	/**
	* Build up url for getting songs from an album.
	*
	* @param string $albumId id of the artist
	*
	* @return string $url url ready for making the request to iTunes API
	*/
	private function urlSongs($albumId){
		$url = "https://itunes.apple.com/lookup?id=".$albumId."&entity=song";
		return($url);
	}
} // end class
?>
