<?php
/*
 * Echo Nest API
 */
class ecApi{
	
	private $key; // Echo Nest user key
	
	/* ============= Constructors ============= */
	
	/**
	* Default constructor 
	*
	* @return void
	*/
	public function __construct(){
		$this->key = "YTHKA6TJ9UY1AIKBD";
	}
	
	
	/**
	* Constructor 
	*
	* @param string $newKey echo nest key
	*
	* @return void
	*/
	public function setKey($newKey){
		$this->key = $newKey;
	}
	
	
	/* ============= Public Methods ============= */
	
	/**
	* Get the top artists of a given genre
	* For each artist it return names and url
	*
	* @param string $genre music genre
	* @param string $numArtists number of the artists to get concerning the $genre
	*
	* @return array $artists array with the top $numArtists artists of $genre. It has $numArtists elements.
							 each element is so composed: key -> artist name, url image;
	*/
	public function getTopArtists($genre, $numArtists){	
		
		/* Build up URL */
		$service_url = $this->urlGenre($genre, $numArtists);
		
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
	
		/* Get artists names and id */
		$artist = ($decoded->response->artists);
		
		$artists = array();
		$ids = array();
		for ($i = 0; $i < $numArtists; $i++) {		
    		$artists[$i] = $artist[$i]->name;
    		$ids[$i] = $artist[$i]->id;
		}
		
		/* Get artists images */
		$images = array();
		for ($i = 0; $i < $numArtists; $i++) {
    		$images[$i] = $this->getImgArtist($ids[$i]);
		}
		
		/* Build up a structure */
		$value = array('nome', 'img');
		$artistsInfo = array_fill(0, $numArtists, $value);	// inizialize structure
		$i=0;
		foreach($artistsInfo as $key=>$el){
			$artistsInfo[$key] = array($artists[$i], $images[$i]); 
			$i++;
		} 
		
		return $artistsInfo;
	} // end getTopArtists


	/**
	* Get image of an artist
	*
	* @param string $id id of an artist
	*
	* @return string $img url of the image
	*/
	public function getImgArtist($id){	
		
		/* Build up URL */
		$service_url = $this->urlArtist($id);

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
	
		/* Get image */
		$img = $decoded->response->images[0]->url;

		return $img;
	} // end getImgArtist


	
	/* ============= Private Methods ============= */
	
	/**
	* Build up url for getting top artist of a given genre.
	*
	* @param string $genre music genre
	* @param string $numArtists number of the artists to get concerning the $genre
	*
	* @return string $url url ready for making the request to Echo Nest Api.
	*/
	private function urlGenre($genre, $numArtists){
		$url = "http://developer.echonest.com/api/v4/genre/artists?api_key=".$this->key."&format=json&results=".$numArtists."&bucket=hotttnesss&name=".$genre;
		return($url);
	}
	
	
	/**
	* Build up url for getting artists info by id.
	*
	* @param string $id of the artist
	*
	* @return string $url url ready for making the request to Echo Nest Api.
	*/
	private function urlArtist($id){
		$url = "http://developer.echonest.com/api/v4/artist/images?api_key=".$this->key."&id=".$id."&format=json&results=1&license=unknown";
		return($url);
	}

	
} // end class
?>
