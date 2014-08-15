<?php
include '../config.php';
function getDBResult($sql){
	$conn = mysql_pconnect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)
	or die('I can not connect to the database');
	if(!$conn){
		$conn = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)  or die('I can not connect to the database');
	}
	mysql_select_db(DB_DATABASE) or die('I can not select database');
	mysql_query("SET NAMES 'utf8'");
	if ($conn) {
		$resource = mysql_query($sql, $conn);

		if ($resource) {
			if (is_resource($resource)) {
				$i = 0;
					
				$data = array();
					
				while ($result = mysql_fetch_assoc($resource)) {
					$data[$i] = $result;

					$i++;
				}
					
				mysql_free_result($resource);
					
				$query = new stdClass();
				$query->row = isset($data[0]) ? $data[0] : array();
				$query->rows = $data;
				$query->num_rows = $i;
					
				unset($data);
				return $query;
			} else {
				return true;
			}
		} else {
			die('Error: ' . mysql_error($conn) . '<br />Error No: ' . mysql_errno($conn) . '<br />' . $sql);
				
		}
	}
}
function strSQLValue($value){
	$mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	
	/* check connection */
	if ($mysqli->connect_errno) {
		die("Connect failed: %s\n". $mysqli->connect_error);
	
	}
	
	return $mysqli->real_escape_string($value);
}
?>