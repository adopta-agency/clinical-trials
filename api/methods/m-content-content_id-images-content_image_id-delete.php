<?php
$route = '/content/:content_id/images/:content_image_id';
$app->delete($route, function ($content_id,$content_image_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$content_id = prepareIdIn($content_id,$host);
	$content_image_id = prepareIdIn($content_image_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	$DeleteQuery = "DELETE FROM content_image WHERE content_image_id = " . $content_image_id;
	$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

	$content_image_id = prepareIdOut($content_image_id,$host);

	$F = array();
	$F['content_image_id'] = $content_image_id;

	array_push($ReturnObject, $F);

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>
