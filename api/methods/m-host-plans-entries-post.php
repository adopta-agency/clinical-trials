<?php
$route = '/host/:host/plans/entries/';
$app->post($route, function ($host) use ($app){

	$hostlookup = $host;
	
	$host = $_SERVER['HTTP_HOST'];

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['host_plan_id'])){ $host_plan_id = mysql_real_escape_string($param['host_plan_id']); } else { $host_plan_id = 0; }
	if(isset($param['entry_label'])){ $entry_label = mysql_real_escape_string($param['entry_label']); } else { $entry_label = 'No Label'; }
	if(isset($param['entry_description'])){ $entry_description = mysql_real_escape_string($param['entry_description']); } else { $entry_description = ''; }
	if(isset($param['entry_metric'])){ $entry_metric = mysql_real_escape_string($param['entry_metric']); } else { $entry_metric = ''; }
	if(isset($param['entry_limit'])){ $entry_limit = mysql_real_escape_string($param['entry_limit']); } else { $entry_limit = ''; }
	if(isset($param['entry_one'])){ $entry_one = mysql_real_escape_string($param['entry_one']); } else { $entry_one = ''; }
	if(isset($param['entry_two'])){ $entry_two = mysql_real_escape_string($param['entry_two']); } else { $entry_two = ''; }
	if(isset($param['entry_unit'])){ $entry_unit = mysql_real_escape_string($param['entry_unit']); } else { $entry_unit = ''; }

	$hostlookup = trim(mysql_real_escape_string($hostlookup));	

	$hostquery = "SELECT * FROM host WHERE host = '" . $hostlookup . "'";
	//echo $hostquery . "<br />";
	$hostresult = mysql_query($hostquery) or die('Query failed: ' . mysql_error());
	
	if($hostresult && mysql_num_rows($hostresult))
		{
			
		$hostitem = mysql_fetch_assoc($hostresult);
		
		$host_id = $hostitem['host_id'];

  		$entryquery = "SELECT * FROM host_plans_entries WHERE host_plan_id = " . $host_plan_id . " AND label = '" . $entry_label . "'";
		//echo $entryquery . "<br />";
		$entryresults = mysql_query($entryquery) or die('Query failed: ' . mysql_error());			
		if($entryresults && mysql_num_rows($entryresults))
			{	
			//$entryresult = mysql_fetch_assoc($entryresults);
			}
		else 
			{
			$query = "INSERT INTO host_plans_entries(host_plan_id,label,description,entry_metric,entry_limit,entry_one,entry_two,entry_unit) VALUES(" . mysql_real_escape_string($host_plan_id) . ",'" . mysql_real_escape_string($entry_label) . "','" . mysql_real_escape_string($entry_description) . "','" . mysql_real_escape_string($entry_metric) . "','" . mysql_real_escape_string($entry_limit) . "','" . mysql_real_escape_string($entry_one) . "','" . mysql_real_escape_string($entry_two) . "','" . mysql_real_escape_string($entry_unit) . "')";
			//echo $query . "<br />";
			mysql_query($query) or die('Query failed: ' . mysql_error());	
			}
			
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
			$plan['entries'] = array();
			
			$query2 = "SELECT * FROM host_plans_entries WHERE host_plan_id = " . $host_plan_id;
			//echo $query2;
			$item2result = mysql_query($query2) or die('Query failed: ' . mysql_error());	
			while ($item2 = mysql_fetch_assoc($item2result))
				{
				$id = $item2['host_plan_entry_id'];	
				$id = prepareIdOut($id,$host);	
				$entry_label = $item2['label'];	
				$entry_description = $item2['description'];
				$entry_metric = $item2['entry_metric'];
				$entry_limit = $item2['entry_limit'];
				$entry_timeframe = $item2['entry_timeframe'];
				$entry_geo = $item2['entry_geo'];
				$entry_element = $item2['entry_element'];
				$entry_one = $item2['entry_one'];
				$entry_two = $item2['entry_two'];
				$entry_unit = $item2['entry_unit'];
				
				$E = array();
				$E['id'] = $id;
				$E['label'] = $entry_label;
				$E['description'] = $entry_description;
				$E['metric'] = $entry_metric;
				$E['limit'] = $entry_limit;
				$E['timeframe'] = $entry_timeframe;
				$E['geo'] = $entry_geo;
				$E['element'] = $entry_element;
				$E['one'] = $entry_one;
				$E['two'] = $entry_two;
				$E['unit'] = $entry_unit;
				
				array_push($plan['entries'], $E);
				}
				
			$plan['elements'] = array();	
			$Query3 = "SELECT * FROM host_plans_elements WHERE host_plan_id = " . $host_plan_id;
			$itemresult3 = mysql_query($Query3) or die('Query failed: ' . mysql_error());	
			while ($item3 = mysql_fetch_assoc($itemresult3))
				{
					
				$name = $item3['name'];
				$id = $item2['host_plan_element_id'];	
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
	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>  