<?php
$route = '/content/:content_id/';
$app->delete($route, function ($content_id) use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$content_id = prepareIdIn($content_id,$host);

	$ReturnObject = array();

	$query = "DELETE FROM content WHERE content_id = " . $content_id;
	//echo $query . "<br />";
	mysql_query($query) or die('Query failed: ' . mysql_error());

	$ReturnObject = array();
	$ReturnObject['message'] = "Note Deleted!";
	$ReturnObject['content_id'] = $content_id;

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_enode($ReturnObject)));

	});
?>
