<?php 
  error_reporting(1);	
  $GLOBALS['useragents'] = array("Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.9.2a1pre) Gecko",
	"Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201",
	"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:9.0a2) Gecko/20111101 Firefox/9.0a2",
	"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0a2) Gecko/20110613 Firefox/6.0a2",
    "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0a2) Gecko/20110612 Firefox/6.0a2",
	"Mozilla/5.0 (X11; U; Linux i586; de; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (X11; U; Linux amd64; rv:5.0) Gecko/20100101 Firefox/5.0 (Debian)",
	"Mozilla/5.0 (X11; U; Linux amd64; en-US; rv:5.0) Gecko/20110619 Firefox/5.0",
	"Mozilla/5.0 (X11; Linux) Gecko Firefox/5.0",
	"Mozilla/5.0 (X11; Linux x86_64; rv:5.0) Gecko/20100101 Firefox/5.0 FirePHP/0.5",
	"Mozilla/5.0 (X11; Linux x86_64; rv:5.0) Gecko/20100101 Firefox/5.0 Firefox/5.0",
	"Mozilla/5.0 (X11; Linux x86_64) Gecko Firefox/5.0",
	"Mozilla/5.0 (X11; Linux ppc; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (X11; Linux AMD64) Gecko Firefox/5.0",
	"Mozilla/5.0 (X11; FreeBSD amd64; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 6.1.1; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 5.2; WOW64; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 5.1; U; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 5.0; WOW64; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows NT 5.0; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (U; Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0",
	"Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US)",
	"Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 7.1; Trident/5.0)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; InfoPath.3; MS-RTC LM 8; .NET4.0C; .NET4.0E)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; chromeframe/12.0.742.112)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; Tablet PC 2.0; InfoPath.3; .NET4.0C; .NET4.0E)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; yie8)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2; .NET CLR 1.1.4322; .NET4.0C; Tablet PC 2.0)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; FunWebProducts)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; chromeframe/13.0.782.215)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; chromeframe/11.0.696.57)",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0) chromeframe/10.0.648.205",
	"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0; chromeframe/11.0.696.57)",
	"Mozilla/5.0 ( ; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)",
	"Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/4.0; FDM; MSIECrawler; Media Center PC 5.0)");

include_once '../config.php';


class db{
	public  $sql="";
	public  $links;
	function connect(){
		$this->links = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
		or die ('I can not connect to the database');
		mysql_select_db(DB_DATABASE,$this->links) or die ('I can not select database');
	}

	#Execute query to database
	 function query($sql)
	 {
		$this->sql= $sql;
		$this->connect();
		
		$return = mysql_query($sql,$this->links);
		return  $return;

	 }
	 
	 #execute query and return ARRAY_A values
	 function fetch($sql,$isone=false)
	 {
	   $this->sql= $sql;
	   $aResult = array();
	   $this->connect();
	   $pResult = mysql_query($sql,$this->links);
	   if($pResult){
			if (mysql_num_rows($pResult) > 0) {
				while ($aRow = mysql_fetch_array($pResult)) {
					$aResult[] = $aRow;
				}
			} else {
				return false;
			}
			
			if($isone == true)
			{
				$aResult=$aResult[0];
			}
			
			return $aResult;
		
		}else{ return false; }
	 }

	  #this is to prevent  XSS attack.
	 function clean($string,$allowhtml=false)
	 {
	   $hack=array("<script","</script>","<style","</style>","<html","</html>","<head","<?","?>","<link","<body","<META",
					"<!DOCTYPE","</head>","<title>","</title>","javascript:");
	   if($allowhtml==true){
	   }else{
	   	$string = strip_tags($string); //remove any HTML code
	   }
	   $string=preg_replace("/(mysql_query|\"|from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/",
				"", $string);
	   $string=addslashes(trim($string));
	   return $string;
	 }

	 public function get_mysql_error()
	 {
	 	return mysql_errno($this->links).' : '.mysql_error($this->links);
	 }

	function check_temp_table(){

		$this->connect();

		if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'temp_csv_upload'"))==1){

		}else{
			 $query5a="CREATE TABLE IF NOT EXISTS 
					temp_csv_upload (
						id int primary key auto_increment,
						itemno VARCHAR(100), 
						brandname VARCHAR(200), 
						productname VARCHAR(200), 
						shortdescription text,
						productdescription text,
						size VARCHAR(100),
						type VARCHAR(100), 
						gender VARCHAR(20), 
						imagelink text, 
						retailprice_aud VARCHAR(100),
						cost_aud VARCHAR(100),
						price VARCHAR(100),
						iscrawled VARCHAR(3)
						)";
			$result5a = mysql_query($query5a)
			or die ('Greska:  $query5a. ' . mysql_error());
		}

		if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'temp_csv_brand'"))==1){

		}else{
			$query5a="CREATE TABLE IF NOT EXISTS 
					temp_csv_brand (
						id int primary key auto_increment,
						brandname VARCHAR(200), 
						branddescription text
						)";
			$result5a = mysql_query($query5a)
			or die ('Greska:  $query5a. ' . mysql_error());
		}
	}
}

$GLOBALS['db'] = new db();



/*
	check db
*/
global $db;
$db->check_temp_table();


function pr($array){
 	echo'<pre>';
 	print_r($array);
 	echo'</pre>';
 }

 function getUserAgent(){
 	global $useragents;
 	return $useragents[rand(0,count($useragents)-1)];
 }


  function get_item_data($itemno){



  	$ch = curl_init();
  	curl_setopt($ch, CURLOPT_URL, "http://www.fragrancex.com/topmenu/search?k=".$itemno);
  	curl_setopt($ch,CURLOPT_USERAGENT,getUserAgent());
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_POST, true);				// The submission type is post
   // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
	curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);	
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt"); // cookies storage / here the changes have been made
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
	curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // the page encoding
	$phpcurl_errorno="";
	$data = curl_exec ($ch); 
	if(curl_errno($ch)){
              echo  "-".'Curl error: ('.curl_errno($ch).') ' . curl_error($ch)."\n\r";
              $data = false;
    }

	curl_close($ch);

	
	return $data;
  }
  
  function get_item_brand($url){



  	$ch = curl_init();
  	curl_setopt($ch, CURLOPT_URL, $url);
  	curl_setopt($ch,CURLOPT_USERAGENT,getUserAgent());
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_POST, true);				// The submission type is post
   // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
	curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);	
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt"); // cookies storage / here the changes have been made
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
	curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // the page encoding
	$phpcurl_errorno="";
	$data = curl_exec ($ch); 
	if(curl_errno($ch)){
              echo  "-".'Curl error: ('.curl_errno($ch).') ' . curl_error($ch)."\n\r";
              $data = false;
    }

	curl_close($ch);

	
	return $data;
  }
  function array2csv(array &$array)
	{
	   if (count($array) == 0) {
	     return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   //fputcsv($df, array_keys(reset($array)));
	   foreach ($array as $row) {
	      fputcsv($df, $row);
	   }
	   fclose($df);
	   return ob_get_clean();
	}

	function download_send_headers($filename) {
	    // disable caching
	    $now = gmdate("D, d M Y H:i:s");
	    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download  
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");

	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename={$filename}");
	    header("Content-Transfer-Encoding: binary");
	}
?>