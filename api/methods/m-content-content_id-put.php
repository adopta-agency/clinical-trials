<?php
$route = '/content/:content_id/';
$app->put($route, function ($content_id) use ($app){

  $host = $_SERVER['HTTP_HOST'];
	$content_id = prepareIdIn($content_id,$host);

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['title'])){ $title = $param['title']; } else { $title = 'No Title'; }
	if(isset($param['details'])){ $details = $param['details']; } else { $details = ''; }

  	$LinkQuery = "SELECT * FROM content WHERE content_id = " . $content_id;
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{
		$query = "UPDATE content SET ";

		if(isset($title))
			{
			$query .= "title='" . mysql_real_escape_string($title) . "'";
			}
		if(isset($content))
			{
			$query .= ",content='" . mysql_real_escape_string($content) . "'";
			}

		$query .= " WHERE content_id = " . $content_id;

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());

    $content_id = prepareIdOut($content_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "Content Updated!";
		$ReturnObject['content_id'] = $content_id;

		}
	else
		{
		$Link = mysql_fetch_assoc($LinkResult);

    $content_id = prepareIdOut($content_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "content Doesn't Exist!";
		$ReturnObject['content_id'] = $content_id;

		}

	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
?>
