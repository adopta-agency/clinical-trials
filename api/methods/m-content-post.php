<?php
$route = '/content/';
$app->post($route, function () use ($app){

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['title'])){ $title = $param['title']; } else { $title = 'No Title'; }
	if(isset($param['details'])){ $details = $param['details']; } else { $details = ''; }

	$post_date = date('Y-m-d H:i:s');
	$increment_date = date('m-d-Y');

  	$LinkQuery = "SELECT * FROM content WHERE title = '" . $title . "'";
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{

		$query = "INSERT INTO content(";

		if(isset($title)){ $query .= "title,"; }
		if(isset($content)){ $query .= "content,"; }
		if(isset($post_date)){ $query .= "post_date"; }

		$query .= ") VALUES(";

		if(isset($title)){ $query .= "'" . mysql_real_escape_string($title) . " - " . $increment_date . "',"; }
		if(isset($content)){ $query .= "'" . mysql_real_escape_string($content) . "',"; }
		if(isset($post_date)){ $query .= "'" . mysql_real_escape_string($post_date) . "'"; }

		$query .= ")";

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$content_id = mysql_insert_id();

    $host = $_SERVER['HTTP_HOST'];
  	$content_id = prepareIdOut($content_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "Content Added";
		$ReturnObject['content_id'] = $content_id;

		}
	else
		{

		$query = "INSERT INTO content(";

		if(isset($title)){ $query .= "title,"; }
		if(isset($content)){ $query .= "content,"; }
		if(isset($post_date)){ $query .= "post_date"; }

		$query .= ") VALUES(";

		if(isset($title)){ $query .= "'" . mysql_real_escape_string($title) . "',"; }
		if(isset($content)){ $query .= "'" . mysql_real_escape_string($content) . "',"; }
		if(isset($post_date)){ $query .= "'" . mysql_real_escape_string($post_date) . "'"; }

		$query .= ")";

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$content_id = mysql_insert_id();

    $host = $_SERVER['HTTP_HOST'];
  	$content_id = prepareIdOut($content_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "Content Added";
		$ReturnObject['content_id'] = $content_id;

		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));

	});
?>
