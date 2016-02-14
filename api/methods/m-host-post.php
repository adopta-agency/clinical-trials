<?php
$route = '/host/';
$app->post($route, function () use ($app){
	
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	
	
	if(isset($params['coupling'])){ $coupling = mysql_real_escape_string($params['coupling']); } else { $coupling = 0; }
	if(isset($params['name'])){ $name = mysql_real_escape_string($params['name']); } else { $name = 'No Name'; }
	if(isset($params['host'])){ $host = mysql_real_escape_string($params['host']); } else { $host = ''; }
	if(isset($params['baseurl'])){ $baseurl = mysql_real_escape_string($params['baseurl']); } else { $baseurl = ''; }

  	$Query = "SELECT * FROM host WHERE host = '" . $host . "'";
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());
	
	if($Database && mysql_num_rows($Database))
		{	
		$ThisBlog = mysql_fetch_assoc($Database);	
		$host_id = $ThisBlog['host_id'];
		}
	else 
		{
		$Query = "INSERT INTO host(coupling,name,host,baseurl)";
		$Query .= " VALUES(";
		$Query .= "'" . mysql_real_escape_string($coupling) . "',";
		$Query .= "'" . mysql_real_escape_string($name) . "',";
		$Query .= "'" . mysql_real_escape_string($host) . "',";
		$Query .= "'" . mysql_real_escape_string($baseurl) . "'";
		$Query .= ")";
		
		//echo $Query . "<br />";
		
		mysql_query($Query) or die('Query failed: ' . mysql_error());
		$host_id = mysql_insert_id();			
		}

	$host = $_SERVER['HTTP_HOST'];
    $geo_id = prepareIdOut($geo_id,$host);

	$ReturnObject['host_id'] = $host_id;
	
	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
?>