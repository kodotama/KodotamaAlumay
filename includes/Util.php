<?php
class Util{
	protected $strings;
	protected $messages;
	
	private static $initialized = false;
	private static function initialize()
	{
		if (self::$initialized)
			return;
	
 		self::$initialized = true;
	}
	

	
	function get_dispatch($url) {
		// Split the URL into its constituent parts.
		$parse = parse_url($url);
	
		// Remove the leading forward slash, if there is one.
		$path = ltrim($parse['path'], '/');
	
		// Put each element into an array.
		$elements = explode('/', $path);
	
		// Create a new empty array.
		$args = array();
	
		// Loop through each pair of elements.
		for( $i = 0; $i < count($elements); $i = $i + 2) {
			$args[$elements[$i]] = $elements[$i + 1];
		}
	
		return $args;
	}
	
	
	public static function  getPageName()
	{
			self::initialize();
		
			$url = $_SERVER ['REQUEST_URI'];
			$paramArray= get_dispatch($url);
			$pageName="";
			if(isset($paramArray["page"]))
		    $pageName=$paramArray["page"];
			
			return $pageName;
	}
	public static function  convertArrayCommaSeperatedString($matchesArray, $tagnameArray)
	{
		    self::initialize();
		    $commaSeperatedString="";
		  
		    foreach ($tagnameArray as $tagname) {
		        
		    	
		    	foreach ($matchesArray[$tagname] as $value) {
		    		$value=str_replace("'", "''", $value);
  		    		$commaSeperatedString=$commaSeperatedString."'".$value."'";
		    		$commaSeperatedString=$commaSeperatedString.",";
		    			
		    	} 
		    }
		    
		    
		    $commaSeperatedString=rtrim($commaSeperatedString, ",");
			return  $commaSeperatedString;
	}
	
	public static function  getTextBetweenTags($string, $tagnameArray)
	{
		self::initialize();
		$matchesArray;
		foreach ($tagnameArray as $tagname) {
		$pattern = "/<$tagname>(.*?)<\/$tagname>/";
		preg_match_all($pattern, $string, $matches);
		$matchesArray[$tagname]=$matches[1];
		}
		return $matchesArray;
	}
   public static function require_with($pg, $vars)
	{
		self::initialize();
	
		require_once $pg;
	}
	public static function url($page) {
		self::initialize();
		$pageArray = array_pad(explode(',', $page), 2, null);
		$paramete=$pageArray[1];
		$page =$pageArray[0];
		$page = preg_replace ( "#^([a-z0-9_-]+)\?#i", '$1&', $page );
	
		$host = $_SERVER ['HTTP_HOST'];
		$mode = ($_SERVER ['SERVER_PORT'] == 443 ? 'https://' : 'http://');
		$path ="/";
		$url = parse_url ( $mode . $host . $path );
		$req_url = $url ['scheme'] . '://' . $url ['host'] . $url ['path'] . '?page=' . $page;
		if($paramete){
			$req_url=$req_url."&urlParam=".$paramete;
			$paramete="";
		}
		return $req_url;
	}
	public static function go($to, $vars = array()) {
		self::initialize();
		$to = preg_replace ( "#^([a-z0-9_-]+)\?#i", '$1&', $to );
		$_SESSION ['vars'] = $vars;
		header ( "Location: ../?page=$to" );
		session_write_close ();
		exit ();
	}
	
	public function get_messages($type, $clear = true) {
		$messages = isset ( $_SESSION ['messages'] [$type] ) ? $_SESSION ['messages'] [$type] : array ();
	
		if ($clear) {
			unset ( $_SESSION ['messages'] [$type] );
		}
	
		return $messages;
	}
	public static function set_message($message, $type = 'error') {
		self::initialize();
		$_SESSION ['messages'] [$type] [] = $message;
	}
	
	public static function lang($string, $vars = array()) {
		self::initialize();

		if (empty ( $strings )) {
			$strings = require (Util::getRoot().'/languages/en-us.php');
		}
	
		$string = isset ( $strings [$string] ) ? $strings [$string] : 'MISSING TRANSLATION: ' . $string;
	
		foreach ( $vars as $key => $value ) {
			$string = str_replace ( $key, $value, $string );
		}
	
		return mb_convert_encoding ( $string, "utf-8", "ISO-8859-9" );
	}
	public static function fatal_error($error) {
		self::initialize();
		die ( $error );
	}
	public static function getRoot(){
		self::initialize();
		$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
		return $root;
	}

	public static	function getDb() {
		self::initialize();
		 $config=Util::getConfig();
	
		$dsn = 'mysql:host=' . $config ['host'] . ';dbname=' . $config ['dbname'] . ';charset=utf8';
		$options = array (
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE
		);
		$db = new PDO ( $dsn, $config ['user'], $config ['pass'], $options );
		$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$db->setAttribute ( PDO::ATTR_AUTOCOMMIT, TRUE );
		$db->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
	
		return $db;
	}	
	
	public static	function getConfig() {
		self::initialize();
		$config = require (Util::getRoot(). '/config.php');
		return $config;
	}
	public static	function startSession() {
		self::initialize();
			
			if(!session_id())
				session_start ();
	}
	
	
	public static	function getFullURL() {
		self::initialize();
			$fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		return $fullURL;
	}
	public static	function curPageURL() {
		self::initialize();
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
}