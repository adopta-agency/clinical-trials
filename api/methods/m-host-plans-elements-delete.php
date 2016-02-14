<?php
$route = '/host/:host/plans/elements/:host_plan_element_id/';
$app->delete($route, function ($host,$host_plan_element_id) use ($app){

	$hostlookup = $host;
	
	$host = $_SERVER['HTTP_HOST'];

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();
	
	$host_plan_element_id = prepareIdIn($host_plan_element_id,$host);
	$hostlookup = trim(mysql_real_escape_string($hostlookup));	

	$hostquery = "DELETE FROM host_plans_elements WHERE host_plan_element_id = " . $host_plan_element_id;
	//echo $hostquery . "<br />";
	$hostresult = mysql_query($hostquery) or die('Query failed: ' . mysql_error());	

	$hostquery = "SELECT * FROM host WHERE host = '" . $hostlookup . "'";
	//echo $hostquery . "<br />";
	$hostresult = mysql_query($hostquery) or die('Query failed: ' . mysql_error());
	
	if($hostresult && mysql_num_rows($hostresult))
		{
			
		$hostitem = mysql_fetch_assoc($hostresult);
		
		$host_id = $hostitem['host_id'];
			
		$spec = array();	
		$spec['plans'] = array();				
		$plans = array();
		
		$Query = "SELECT * FROM host_plans WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$host_plan_id = $item['host_plan_id'];
			$plan_name = $item['name'];
			//echo $plan_name . "<br />";
			$plan_description = $item['description'];
			
			$Plan = array();	
			$plan['id'] = $host_plan_id;
			$plan['name'] = $plan_name;
			$plan['description'] = $plan_description;
			$plan['elements'] = array();			
				
			$plan['elements'] = array();	
			$Query3 = "SELECT * FROM host_plans_elements WHERE host_plan_id = " . $host_plan_id;
			$itemresult3 = mysql_query($Query3) or die('Query failed: ' . mysql_error());	
			while ($item3 = mysql_fetch_assoc($itemresult3))
				{
					
				$name = $item3['name'];
				$id = $item3['host_plan_element_id'];	
				$id = prepareIdOut($id,$host);
				
				$E = array();
				$E['id'] = $id;
				$E['name'] = $name;
								
				array_push($plan['elements'], $E);
				}

			array_push($plans,$plan);
											
			}

		$spec['plans'] = $plans;	

		}				
	$ReturnObject = $spec;
	//echo(json_encode($spec));
	//$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>  