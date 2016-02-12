<?php
$route = '/content/tags/:tag';
$app->delete($route, function ($tag)  use ($app){

	$ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

	$Query = "SELECT t.tag_id, t.tag FROM tags WHERE tag = '" . trim(mysql_real_escape_string($tag)) . "'";

	$tagResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($tagResult && mysql_num_rows($tagResult))
		{
		$tag = mysql_fetch_assoc($tagResult);
		$tag_id = $tag['tag_id'];
		$tag_Text = $tag['tag'];

		$DeleteQuery = "DELETE FROM content_tag_pivot WHERE tag_id = " . $tag_id;
		$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

		$DeleteQuery = "DELETE FROM tags WHERE tag = '" . trim(mysql_real_escape_string($tag)) . "'";
		$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

		$host = $_SERVER['HTTP_HOST'];
		$tag_id = prepareIdOut($tag_id,$host);

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag_Text;
		$F['profile_count'] = 0;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>
