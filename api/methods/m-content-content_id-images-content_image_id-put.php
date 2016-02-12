<?php
$route = '/content/:content_id/images/:content_image_id';
$app->put($route, function ($content_id,$content_image_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$content_id = prepareIdIn($content_id,$host);
	$content_image_id = prepareIdIn($content_image_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['path']))
		{
		$type = trim(mysql_real_escape_string($param['type']));
		$path = trim(mysql_real_escape_string($param['path']));
		$name = trim(mysql_real_escape_string($param['name']));

		$query = "UPDATE content_image SET type = '" . $type . "', image_url = '" . $path . "', image_name = '" . $name . "' WHERE content_image_id = " . $content_image_id;
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
