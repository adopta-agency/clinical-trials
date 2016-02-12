<?php
$route = '/content/:content_id/images/';
$app->get($route, function ($content_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$content_id = prepareIdIn($content_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * FROM content_image ls";
	$Query .= " WHERE ls.content_id = " . $content_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$content_image_id = $Database['content_image_id'];
		$path = $Database['image_url'];
		$name = $Database['image_name'];
		$type = $Database['type'];
		$width = $Database['width'];

		$content_image_id = prepareIdOut($content_image_id,$host);

		$F = array();
		$F['content_image_id'] = $content_image_id;
		$F['name'] = $name;
		$F['path'] = $path;
		$F['type'] = $type;
		$F['width'] = $width;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>
