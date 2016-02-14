<?php
$route = '/base/';
$app->get($route, function ()  use ($app){

	$host = $_SERVER['HTTP_HOST'];

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();	
		
	$ReturnObject['elements'] = array();
	$Query = "SELECT * FROM elements ORDER BY Name";
	$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
	while ($item = mysql_fetch_assoc($itemresult))
		{
		$id = $item['element_id'];
		$name = $item['name'];			
		$id = prepareIdOut($id,$host);
		
		$P = array();
		$P['id'] = $id;
		$P['name'] = $name;
		
		array_push($ReturnObject['elements'], $P);				
		}		
			
	$ReturnObject['timeframes'] = array();
	$Query = "SELECT * FROM timeframes ORDER BY Name";
	$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
	while ($item = mysql_fetch_assoc($itemresult))
		{
		$id = $item['timeframe_id'];
		$name = $item['name'];			
		$id = prepareIdOut($id,$host);
		
		$P = array();
		$P['id'] = $id;
		$P['name'] = $name;
		
		array_push($ReturnObject['timeframes'], $P);
		}			
		
	$ReturnObject['metrics'] = array();
	$Query = "SELECT * FROM metrics ORDER BY Name";
	$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
	while ($item = mysql_fetch_assoc($itemresult))
		{
		$id = $item['metric_id'];
		$name = $item['name'];			
		$id = prepareIdOut($id,$host);
		
		$P = array();
		$P['id'] = $id;
		$P['name'] = $name;
		
		array_push($ReturnObject['metrics'], $P);
		}
				
	$ReturnObject['geo'] = array();
	$Query = "SELECT * FROM geo ORDER BY Name";
	$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
	while ($item = mysql_fetch_assoc($itemresult))
		{
		$id = $item['geo_id'];
		$name = $item['name'];			
		$id = prepareIdOut($id,$host);
		
		$P = array();
		$P['id'] = $id;
		$P['name'] = $name;
		
		array_push($ReturnObject['geo'], $P);
		}
				
	$ReturnObject['limits'] = array();
	$Query = "SELECT * FROM limits ORDER BY Name";
	$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
	while ($item = mysql_fetch_assoc($itemresult))
		{
		$id = $item['limit_id'];
		$name = $item['name'];			
		$id = prepareIdOut($id,$host);
		
		$P = array();
		$P['id'] = $id;
		$P['name'] = $name;
		
		array_push($ReturnObject['limits'], $P);
		}
				
	$ReturnObject['resources'] = array();
	$Query = "SELECT * FROM resources ORDER BY Name";
	$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
	while ($item = mysql_fetch_assoc($itemresult))
		{
		$id = $item['resource_id'];
		$name = $item['name'];			
		$id = prepareIdOut($id,$host);
		
		$P = array();
		$P['id'] = $id;
		$P['name'] = $name;
		
		array_push($ReturnObject['resources'], $P);
		}	
			
	$ReturnObject['extensions'] = array();
	$Query = "SELECT * FROM extensions ORDER BY Name";
	$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
	while ($item = mysql_fetch_assoc($itemresult))
		{
		$id = $item['extension_id'];
		$name = $item['name'];			
		$id = prepareIdOut($id,$host);
		
		$P = array();
		$P['id'] = $id;
		$P['name'] = $name;
		
		array_push($ReturnObject['extensions'], $P);
		}	
			
	//echo(json_encode($ReturnObject));
	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>  