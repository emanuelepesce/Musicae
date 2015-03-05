<?php
/*
 * Last.fm Api
 */
class fmApi{
	
	private $key;
	
	/* ============= Constructors ============= */
	
	/**
	* Default constructor 
	*
	* @return void
	*/
	public function __construct(){
		$this->key = "453672b209a0bf580eecb819259594d3";
	}
	
	
	/**
	* Constructor 
	*
	* @param string $newKey api key
	*
	* @return void
	*/
	public function setKey($newKey){
		$this->key = $newKey;
	}
	
	
	/* ============= Public Methods ============= */


	/**
	* Return the weekly chart of the albums of a given genre
	*
	* @param string $genre genre
	* @param string $num number of elements to put into the chart
	*
	* @return array $chart chart of artists of the genre $genre.
	*/
	public function getChartAlbums($genre, $num){	
		
		/* Build up URL */
		$artist = strtolower($genre);
		$service_url = $this->urlChartGenre($genre);

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
		

		$chart = array();
		for ($i=0; $i<$num;$i++){
			$chart[$i] = $decoded->weeklyartistchart->artist[$i]->name;
		}
		
		return $chart;
	}//end getChartAlbums



	
	/* ============= Private Methods ============= */
	
	/**
	* Build up url for getting char of a genre
	*
	* @param string $genre name of the genre
	*
	* @return string $url url ready for making the request to Api
	*/
	private function urlChartGenre($genre){
		$url="http://ws.audioscrobbler.com/2.0/?method=tag.getweeklyartistchart&tag=".$genre."&api_key=".$this->key."&format=json";
		return($url);
	}

	
	
} // end class
?>
