<?php
$route = '/extensions/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['name'])){ $name = trim(mysql_real_escape_string($param['name'])); } else { $name = '';}
	
	//echo "query: " . $query . "<br />";
	$Query = "SELECT * FROM extensions e";
	if($name!='')
		{	
		$Query .= " WHERE name LIKE '%" . $name . "'";
		}
	$Query .= " ORDER BY name";
	//echo $Query . "<br />";

	$contentResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($content = mysql_fetch_assoc($contentResult))
		{

		$extension_id = $content['extension_id'];
		$name = $content['name'];
		
		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$extension_id = prepareIdOut($extension_id,$host);

		$F = array();
		$F['extension_id'] = $extension_id;
		$F['name'] = $name;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>
