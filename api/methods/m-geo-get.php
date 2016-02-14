<?php
$route = '/geo/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['query'])){ $query = trim(mysql_real_escape_string($param['query'])); } else { $query = '';}
	
	//echo "query: " . $query . "<br />";
	$Query = "SELECT * FROM geo e";
	$Query .= " WHERE name LIKE '%" . $query . "'";
	$Query .= " ORDER BY name";
	//echo $Query . "<br />";

	$contentResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($content = mysql_fetch_assoc($contentResult))
		{

		$geo_id = $content['geo_id'];
		$name = $content['name'];
		
		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$geo_id = prepareIdOut($geo_id,$host);

		$F = array();
		$F['geo_id'] = $geo_id;
		$F['name'] = $name;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>
