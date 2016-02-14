<?php
$route = '/spec/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['host'])){ $host = trim(mysql_real_escape_string($param['host'])); } else { $host = '';}	
	
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
		
		$spec['pages'] = array();
		$Query = "SELECT * FROM host_pages WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$url = $item['url'];
			array_push($spec['pages'], $url);
			}		
		
		$spec['elements'] = array();
		$Query = "SELECT * FROM host_elements WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$name = $item['name'];
			array_push($spec['elements'], $name);
			}		
			
		$spec['timeframes'] = array();
		$Query = "SELECT * FROM host_timeframes WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$name = $item['name'];
			array_push($spec['timeframes'], $name);
			}			
			
		$spec['metrics'] = array();
		$Query = "SELECT * FROM host_metrics WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$name = $item['name'];
			array_push($spec['metrics'], $name);
			}
					
		$spec['geo'] = array();
		$Query = "SELECT * FROM host_geo WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$name = $item['name'];
			array_push($spec['geo'], $name);
			}
					
		$spec['limits'] = array();
		$Query = "SELECT * FROM host_limits WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$name = $item['name'];
			array_push($spec['limits'], $name);
			}
					
		$spec['resources'] = array();
		$Query = "SELECT * FROM host_resources WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$name = $item['name'];
			array_push($spec['resources'], $name);
			}	
				
		$spec['extensions'] = array();
		$Query = "SELECT * FROM host_extensions WHERE host_id = " . $host_id;
		$itemresult = mysql_query($Query) or die('Query failed: ' . mysql_error());	
		while ($item = mysql_fetch_assoc($itemresult))
			{
			$name = $item['name'];
			array_push($spec['extensions'], $name);
			}	
					
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
			$plan['name'] = $plan_name;
			$plan['description'] = $plan_description;
			$plan['entries'] = array();
			
			$query2 = "SELECT * FROM host_plans_entries WHERE host_plan_id = " . $host_plan_id;
			//echo $query2;
			$item2result = mysql_query($query2) or die('Query failed: ' . mysql_error());	
			while ($item2 = mysql_fetch_assoc($item2result))
				{
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
				array_push($plan['elements'], $name);
				}

			array_push($plans,$plan);
											
			}

		$spec['plans'] = $plans;	

		}

	array_push($ReturnObject,$spec);
	
	//echo(json_encode($spec));
	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>  