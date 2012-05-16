<?php

require_once('db_connection.php');

$url = (isset($_GET['url']) ? $_GET['url'] : (isset($_POST['url']) ? $_POST['url'] : false));
$debug = ((isset($_GET['debug']) && $_GET['debug'] == 1) ? true : false); //If debug is true, and this page is visited directly, console.log whatever the f*ck is going on.

if(!empty($url)) {

	#An URL is recieved. Store it!
	$insertSql = "INSERT INTO click_catch SET url = '". mysql_real_escape_string($url) ."', created_on = '". date('Y-m-d H:i:s', time()) ."'";
	$insertQuery = mysql_query($insertSql);

	if($insertQuery == true) {
		
		#It's true baby!
		$response = array("succeeded" => "true");

	} else {

		#Baah, false.
		$response = array("succeeded" => "false");

		if($debug === true) $error = 'Could not insert into database. Query: '. $url .' - Error: '. mysql_error();

	}

} else {

	#Empty or no url given
	$response = array("succeeded" => "false");

	if($debug === true) $error = 'Empty or no url given';

}


#Give feedback!
if($debug == false) {
		
	echo json_encode($response);

} else {

	#Debug is on, expecting error
	if(isset($error)) {

		echo $error;

	} else {

		echo 'No errors. This should work, and '. $url .' should really have been added!';

	}
}

exit();

?>