<?php
/*
 * Library for using DOMDocument
 */
 class libDom{
    
		/* ============= Constructors ============= */
		/**
		* Default constructor 
		* 
		* @return void
		*/
        public function __construct(){
            
        }
        /* ============= Public Methods ============= */
		
		/**
		* Get DOMXPath from url
		*
		* @param string $url url of site 
		*
		* @return DOMXPath $xPath else it return error
		*/
         public function getDOM($url){		
			error_reporting(E_ERROR | E_PARSE); //suppress warning 
			
            libxml_use_internal_errors(TRUE);			 
            $document = new DOMDocument;
                
            /* Options for working with file_get_contents*/
            $arrContextOptions=array(
   				"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
  			  ),
			);  
			
			
			/* Launch exeption if there are no lyrics*/
			if ( ($f = file_get_contents($url, false, stream_context_create($arrContextOptions)))===false ){
       			 throw new Exception('Error.');
    
			}
            
			/* ALternative to file get contents*/
			#$curl = curl_init();
			#curl_setopt($curl, CURLOPT_URL, $url);
			#curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			#curl_setopt($curl, CURLOPT_HEADER, false);
			#curl_setopt($curl, CURLOPT_SSLVERSION, 3);
			#$f= curl_exec($curl);
			#curl_close($curl);
			
            $document->loadHTML($f);
            libxml_clear_errors();
            $xPath = new DOMXPath($document);
            return $xPath;
        }
        
    }

?>
