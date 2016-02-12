<?php
$route = '/content/:content_id/images/';
$app->post($route, function ($content_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$content_id = prepareIdIn($content_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();
	if(isset($param['type']) && isset($param['path']) && isset($param['name']))
		{
		$type = trim(mysql_real_escape_string($param['type']));
		$path = trim(mysql_real_escape_string($param['path']));
		$name = trim(mysql_real_escape_string($param['name']));

		$query = "INSERT INTO content_image(content_id,type,image_name,image_url)";
		$query .= " VALUES(" . $content_id . ",'" . $type . "','" . $name . "','" . $path . "')";
		//echo $query;
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$image_id = mysql_insert_id();

		$image_id = prepareIdOut($image_id,$host);

		$F = array();
		$F['image_id'] = $image_id;
		$F['name'] = $name;
		$F['path'] = $path;
		$F['type'] = $type;

		array_push($ReturnObject, $F);

		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>
