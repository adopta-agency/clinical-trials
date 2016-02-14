<?php
$route = '/host/:host/plans/:host_plan_id/';
$app->delete($route, function ($host,$host_plan_id) use ($app){

	$hostlookup = $host;
	
	$host = $_SERVER['HTTP_HOST'];

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	$hostlookup = trim(mysql_real_escape_string($hostlookup));
	$host_plan_id = trim(mysql_real_escape_string($host_plan_id));	
	$host_plan_id = prepareIdIn($host_plan_id,$host);

	$hostquery = "SELECT * FROM host WHERE host = '" . $hostlookup . "'";
	//echo $hostquery . "<br />";
	$hostresult = mysql_query($hostquery) or die('Query failed: ' . mysql_error());
	
	if($hostresult && mysql_num_rows($hostresult))
		{
			
		$hostitem = mysql_fetch_assoc($hostresult);		
		$host_id = $hostitem['host_id'];
		
		$Query = "DELETE FROM host_plans WHERE host_plan_id = " . $host_plan_id;
		//echo $Query . "<br />";
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	

		}
						
	$ReturnObject['remove'] = 1;

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>  