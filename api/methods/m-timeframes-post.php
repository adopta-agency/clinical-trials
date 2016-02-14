<?php
$route = '/timeframes/';	
$app->post($route, function () use ($app){
	
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	
	
	if(isset($params['name'])){ $name = mysql_real_escape_string($params['name']); } else { $name = 'No Name'; }

  	$Query = "SELECT * FROM timeframes WHERE name = '" . $name . "'";
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());
	
	if($Database && mysql_num_rows($Database))
		{	
		$ThisBlog = mysql_fetch_assoc($Database);	
		$timeframe_id = $ThisBlog['timeframe_id'];
		}
	else 
		{
		$Query = "INSERT INTO timeframes(name)";
		$Query .= " VALUES(";
		$Query .= "'" . mysql_real_escape_string($name) . "'";
		$Query .= ")";
		
		//echo $Query . "<br />";
		
		mysql_query($Query) or die('Query failed: ' . mysql_error());
		$timeframe_id = mysql_insert_id();			
		}

	$host = $_SERVER['HTTP_HOST'];
    $timeframe_id = prepareIdOut($timeframe_id,$host);

	$ReturnObject['timeframe_id'] = $timeframe_id;
	
	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
?>