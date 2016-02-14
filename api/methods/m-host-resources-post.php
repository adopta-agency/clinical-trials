<?php
$route = '/host/:host/resources/';
$app->post($route, function ($host) use ($app){

	$hostlookup = $host;
	
	$host = $_SERVER['HTTP_HOST'];

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['name'])){ $name = mysql_real_escape_string($param['name']); } else { $name = 'No Name'; }
	$host = trim(mysql_real_escape_string($hostlookup));	

	$hostquery = "SELECT * FROM host WHERE host = '" . $host . "'";
	//echo $hostquery . "<br />";
	$hostresult = mysql_query($hostquery) or die('Query failed: ' . mysql_error());
	
	if($hostresult && mysql_num_rows($hostresult))
		{
			
		$hostitem = mysql_fetch_assoc($hostresult);
		
		$host_id = $hostitem['host_id'];
		$host_coupling = $hostitem['coupling'];
		$host_name = $hostitem['name'];
		//echo $host_name . "<br />";	
		$host_host = $hostitem['host'];	
		$host_baseurl = $hostitem['baseurl'];				
		
		$spec = array();
		
		$spec['coupling'] = $host_coupling;
		$spec['name'] = $host_name;
		$spec['host'] = $host_host;
		$spec['baseurl'] = $host_baseurl;
		$spec['plans'] = array();
		
		// Add Elements for Host
  		$HostElementQuery = "SELECT * FROM host_resources WHERE host_id = " . $host_id . " AND name = '" . $name . "'";
		//echo $HostElementQuery . "<br />";
		$HostElementResults = mysql_query($HostElementQuery) or die('Query failed: ' . mysql_error());
		
		if($HostElementResults && mysql_num_rows($HostElementResults))
			{	
			$HostElement = mysql_fetch_assoc($HostElementResults);	
			}
		else 
			{
			$query = "INSERT INTO host_resources(host_id,name) VALUES(" . $host_id . ",'" . mysql_real_escape_string($name) . "')";
			echo $query . "<br />";
			mysql_query($query) or die('Query failed: ' . mysql_error());			
			}		
				
		$spec['resources'] = array();
		$Query = "SELECT * FROM host_resources WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$id = $item['host_resource_id'];
			$name = $item['name'];			
			$id = prepareIdOut($id,$host);
			
			$P = array();
			$P['id'] = $id;
			$P['name'] = $name;
			
			array_push($spec['resources'], $P);				
			}		

		}

	array_push($ReturnObject,$spec);
	
	//echo(json_encode($spec));
	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>  