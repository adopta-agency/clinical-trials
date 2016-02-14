<?php
$route = '/limits/';	
$app->post($route, function () use ($app){
	
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	
	
	if(isset($params['name'])){ $name = mysql_real_escape_string($params['name']); } else { $name = 'No Name'; }

  	$Query = "SELECT * FROM limits WHERE name = '" . $name . "'";
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());
	
	if($Database && mysql_num_rows($Database))
		{	
		$ThisBlog = mysql_fetch_assoc($Database);	
		$limit_id = $ThisBlog['limit_id'];
		}
	else 
		{
		$Query = "INSERT INTO limits(name)";
		$Query .= " VALUES(";
		$Query .= "'" . mysql_real_escape_string($name) . "'";
		$Query .= ")";
		
		//echo $Query . "<br />";
		
		mysql_query($Query) or die('Query failed: ' . mysql_error());
		$limit_id = mysql_insert_id();			
		}

	$host = $_SERVER['HTTP_HOST'];
    $limit_id = prepareIdOut($limit_id,$host);

	$ReturnObject['limit_id'] = $limit_id;
	
	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
?>