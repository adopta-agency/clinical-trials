<?php
$route = '/content/tags/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

	$Query = "SELECT t.tag_id, t.tag, count(*) AS Profile_Count from tags t";
	$Query .= " INNER JOIN content_tag_pivot ctp ON t.tag_id = ctp.tag_id";
	$Query .= " GROUP BY t.tag ORDER BY count(*) DESC";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['tag_id'];
		$tag = $Database['tag'];
		$profile_count = $Database['Profile_Count'];

		$host = $_SERVER['HTTP_HOST'];
		$tag_id = prepareIdOut($tag_id,$host);

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['profile_count'] = $profile_count;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>
