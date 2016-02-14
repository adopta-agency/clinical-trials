<?php
$route = '/elements/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['name'])){ $name = trim(mysql_real_escape_string($param['name'])); } else { $name = '';}
	
	//echo "query: " . $name . "<br />";
	$Query = "SELECT * FROM elements e";
	if($name!='')
		{
		$Query .= " WHERE name LIKE '%" . $name . "'";
		}
	$Query .= " ORDER BY name";
	//echo $Query . "<br />";

	$contentResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($content = mysql_fetch_assoc($contentResult))
		{

		$element_id = $content['element_id'];
		$name = $content['name'];
		
		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$element_id = prepareIdOut($element_id,$host);

		$F = array();
		$F['element_id'] = $element_id;
		$F['name'] = $name;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>
