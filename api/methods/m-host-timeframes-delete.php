<?php
$route = '/host/:host/timeframes/:name/';
$app->delete($route, function ($host,$name) use ($app){

	$hostlookup = $host;
	
	$host = $_SERVER['HTTP_HOST'];

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	$host = trim(mysql_real_escape_string($hostlookup));
	$name = trim(mysql_real_escape_string($name));	

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
  		$HostElementQuery = "DELETE FROM host_timeframes WHERE host_id = " . $host_id . " AND name = '" . $name . "'";
		//echo $HostElementQuery . "<br />";
		$HostElementResults = mysql_query($HostElementQuery) or die('Query failed: ' . mysql_error());		
				
		$spec['timeframes'] = array();
		$Query = "SELECT * FROM host_timeframes WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$id = $item['host_timeframe_id'];
			$name = $item['name'];			
			$id = prepareIdOut($id,$host);
			
			$P = array();
			$P['id'] = $id;
			$P['name'] = $name;
			
			array_push($spec['timeframes'], $P);				
			}		

		}

	array_push($ReturnObject,$spec);
	
	//echo(json_encode($spec));
	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>  