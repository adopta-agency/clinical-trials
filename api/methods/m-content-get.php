<?php
$route = '/content/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['query'])){ $query = trim(mysql_real_escape_string($param['query'])); } else { $query = '';}
	if(isset($param['page'])){ $page = trim(mysql_real_escape_string($param['page'])); } else { $page = 0;}
	if(isset($param['count'])){ $count = trim(mysql_real_escape_string($param['count'])); } else { $count = 250;}
	if(isset($param['sort'])){ $sort = trim(mysql_real_escape_string($param['sort'])); } else { $sort = 'modified_date';}
	if(isset($param['order'])){ $order = trim(mysql_real_escape_string($param['order'])); } else { $order = 'DESC';}
	//echo "query: " . $query . "<br />";
	$Query = "SELECT DISTINCT n.content_id,n.title,n.details,n.post_date,n.modified_date FROM content n";
	//$Query .= " INNER JOIN content_tag_pivot npt ON n.content_id = npt.content_id";
	//$Query .= " INNER JOIN tags t ON npt.tag_id = t.tag_id";
	$Query .= " WHERE n.content_id is not null";
	if($query!='')
		{
		$Query .= " AND (n.title LIKE '%" . $query . "%' OR n.details LIKE '%" . $query . "%')";
		}
	$Query .= " ORDER BY n." . $sort . " " . $order . " LIMIT " . $page . "," . $count;
	//echo $Query . "<br />";

	$contentResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($content = mysql_fetch_assoc($contentResult))
		{

		$archive = 0;
		$content_id = $content['content_id'];
		$title = $content['title'];
		$details = $content['details'];
		$post_date = $content['post_date'];
		$modified_date = $content['modified_date'];

		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$content_id = prepareIdOut($content_id,$host);

		$F = array();
		$F['content_id'] = $content_id;
		$F['title'] = $title;
		$F['details'] = $details;
		$F['post_date'] = $post_date;
		$F['modified_date'] = $modified_date;
		$F['tags'] = array();

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

		if($archive==0)
			{
			array_push($ReturnObject, $F);
			}
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>
