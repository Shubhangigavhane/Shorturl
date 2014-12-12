<?php
// load smarty liabrary
require('C:/xampp/htdocs/shubhangi/smarty_connect.php');


class MakeShortUrl {

	public $long_url;

	function __construct()
	{
		$this->long_url = isset($_POST['longurl']) ? $_POST['longurl'] : null;
	}
	
	
	public function shotenUrl($longUrl, $access_token, $domain)
	{
  		$url = 'https://api-ssl.bitly.com/v3/shorten?access_token='.$access_token.'&longUrl='.urlencode($longUrl).'&domain='.$domain;
  		try {
    		$ch = curl_init($url);
    		curl_setopt($ch, CURLOPT_HEADER, 0);
    		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
    		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    		$output = json_decode(curl_exec($ch));
  		} catch (Exception $e) {
  		}
  			if(isset($output)){return $output->data->url;}
	}

	
	public function displayUrl(){
		
		$smarty = new smarty_connect;
		
		$conn = mysql_connect( '127.0.0.1', 'root', '');
		if (!$conn) {
			die('Could not connect: ' . mysql_error());
		}
		
		$selected_db = mysql_select_db("customer_portal",$conn)
		or die("Could not connect to customer_portal");
		
		//create table url if not exits
		$tableresult = mysql_query("CREATE TABLE IF NOT EXISTS `url` (
   									`id` int UNIQUE NOT NULL,
  									 `long_url` varchar(1000),
  									 `short_url` varchar(50),
   										PRIMARY KEY(id));");
		
			
		if(isset($_POST['longurl'])) {
			$shorturl = self::shotenUrl( $this->long_url, '966a102f37991489e38790f15757e4af38c46ba4', 'bit.ly');
			$smarty->assign('long_url', $_POST['longurl']);
			$smarty->assign('short_url', $shorturl);
		}
		
		 // Insert long and short url into Url table
		if(isset($_POST['longurl']) && isset($shorturl)) {
			
			$checkurl=mysql_query("SELECT long_url,short_url FROM url WHERE long_url = '".$_POST['longurl']."' AND short_url = '".$shorturl."' limit 1");
			$urlrow = mysql_fetch_row($checkurl);
						
			if( ($urlrow[0] != $_POST['longurl']) && ($urlrow[1] != $shorturl) ) {
				$insertsql = "INSERT INTO url (long_url, short_url)	VALUES ( '". $_POST['longurl']."','". $shorturl ."' )";
				$insetedrow = mysql_query($insertsql, $conn);
			}
		
		}
		
		//close the connection
		mysql_close($conn);
			
		$smarty->display('makeshorturl.tpl');
	}
}

$shortUrl = new MakeShortUrl();
$shortUrl->displayUrl();






?>