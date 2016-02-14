<?php
$route = '/metrics/';	
$app->post($route, function () use ($app){
	
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	
	
	if(isset($params['name'])){ $name = mysql_real_escape_string($params['name']); } else { $name = 'No Name'; }

  	$Query = "SELECT * FROM metrics WHERE name = '" . $name . "'";
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());
	
	if($Database && mysql_num_rows($Database))
		{	
		$ThisBlog = mysql_fetch_assoc($Database);	
		$metric_id = $ThisBlog['metric_id'];
		}
	else 
		{
		$Query = "INSERT INTO metrics(name)";
		$Query .= " VALUES(";
		$Query .= "'" . mysql_real_escape_string($name) . "'";
		$Query .= ")";
		
		//echo $Query . "<br />";
		
		mysql_query($Query) or die('Query failed: ' . mysql_error());
		$metric_id = mysql_insert_id();			
		}

	$host = $_SERVER['HTTP_HOST'];
    $metric_id = prepareIdOut($metric_id,$host);

	$ReturnObject['metric_id'] = $metric_id;
	
	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
?>