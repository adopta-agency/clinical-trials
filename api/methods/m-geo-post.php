<?php
$route = '/geo/';	
$app->post($route, function () use ($app){
	
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	
	
	if(isset($params['name'])){ $name = mysql_real_escape_string($params['name']); } else { $name = 'No Name'; }

  	$Query = "SELECT * FROM geo WHERE name = '" . $name . "'";
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());
	
	if($Database && mysql_num_rows($Database))
		{	
		$ThisBlog = mysql_fetch_assoc($Database);	
		$geo_id = $ThisBlog['geo_id'];
		}
	else 
		{
		$Query = "INSERT INTO geo(name)";
		$Query .= " VALUES(";
		$Query .= "'" . mysql_real_escape_string($name) . "'";
		$Query .= ")";
		
		//echo $Query . "<br />";
		
		mysql_query($Query) or die('Query failed: ' . mysql_error());
		$geo_id = mysql_insert_id();			
		}

	$host = $_SERVER['HTTP_HOST'];
    $geo_id = prepareIdOut($geo_id,$host);

	$ReturnObject['geo_id'] = $geo_id;
	
	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
?>