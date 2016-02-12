<?php
$route = '/content/:content_id/';
$app->get($route, function ($content_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$content_id = prepareIdIn($content_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * FROM content WHERE content_id = " . $content_id;
	//echo $Query . "<br />";

	$contentResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($content = mysql_fetch_assoc($contentResult))
		{

		$content_id = $content['content_id'];
		$title = $content['title'];
		$details = $content['details'];
		$post_date = $content['post_date'];

		$TagQuery = "SELECT t.tag_id, t.tag from tags t";
		$TagQuery .= " INNER JOIN content_tag_pivot npt ON t.tag_id = npt.tag_id";
		$TagQuery .= " WHERE npt.content_ID = " . $content_id;
		$TagQuery .= " ORDER BY t.tag DESC";
		$TagResult = mysql_query($TagQuery) or die('Query failed: ' . mysql_error());

		while ($Tag = mysql_fetch_assoc($TagResult))
			{
			$thistag = $Tag['tag'];

			$T = array();
			$T = $thistag;
			array_push($F['tags'], $T);
			//echo $thistag . "<br />";
			if($thistag=='Archive')
				{
				$archive = 1;
				}
			}

		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$content_id = prepareIdOut($content_id,$host);

		$F = array();
		$F['content_id'] = $content_id;
		$F['title'] = $title;
		$F['details'] = $details;
		$F['post_date'] = $post_date;
		$F['tags'] = array();

		$ReturnObject = $F;
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>
