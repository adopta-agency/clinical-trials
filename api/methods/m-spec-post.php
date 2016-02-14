<?php
$route = '/spec/';	
$app->post($route, function () use ($app){
	
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	
	$body = $request->getBody();

	$speclisting = json_decode($body,true);
	foreach($speclisting as $spec)
		{
		//var_dump($spec);
		$coupling = $spec['coupling'];
		$name = $spec['name'];
		$host = $spec['host'];
		$baseurl = $spec['baseurl'];
		
  		$hostquery = "SELECT * FROM host WHERE host = '" . $host . "'";
		//echo $hostquery . "<br />";
		$hostresult = mysql_query($hostquery) or die('Query failed: ' . mysql_error());
		
		if($hostresult && mysql_num_rows($hostresult))
			{	
			$hostitem = mysql_fetch_assoc($hostresult);
			$host_id = 	$hostitem['host_id'];
			}
		else 
			{
			$query = "INSERT INTO host(coupling,name,host,baseurl) VALUES('" . mysql_real_escape_string($coupling) . "','" . mysql_real_escape_string($name) . "','" . mysql_real_escape_string($host) . "','" . mysql_real_escape_string($baseurl) . "')";
			//echo $query . "<br />";
			mysql_query($query) or die('Query failed: ' . mysql_error());
			$host_id = mysql_insert_id();			
			}		
		
		// Pages
		$pages = $spec['pages'];	
		if(is_array($pages))
			{	
			foreach($pages as $url)
				{		
		  		$hostpagequery = "SELECT * FROM host_pages WHERE host_id = " . $host_id . " AND url = '" . $url . "'";
				//echo $hostquery . "<br />";
				$hostpageresult = mysql_query($hostpagequery) or die('Query failed: ' . mysql_error());			
				if($hostpageresult && mysql_num_rows($hostpageresult))
					{	
					$hostpage = mysql_fetch_assoc($hostpageresult);
					$host_page_id = $hostpage['host_page_id'];
					}
				else 
					{
					$query = "INSERT INTO host_pages(host_id,url) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($url) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());
					$host_page_id = mysql_insert_id();			
					}			
				}
			}
			
		$elements = $spec['elements'];
		if(is_array($elements))
			{			
			foreach($elements as $element)
				{
					
				// Elements		
		  		$elementquery = "SELECT * FROM elements WHERE name = '" . $element . "'";
				//echo $elementquery . "<br />";
				$elementresult = mysql_query($elementquery) or die('Query failed: ' . mysql_error());			
				if($elementresult && mysql_num_rows($elementresult))
					{	
					//$element = mysql_fetch_assoc($elementresult);
					}
				else 
					{
					$query = "INSERT INTO elements(name) VALUES('" . mysql_real_escape_string($element) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());	
					}	
					
				// Host Elements
		  		$hostelementquery = "SELECT * FROM host_elements WHERE host_id = " . $host_id . " AND name = '" . $element . "'";
				//echo $hostquery . "<br />";
				$hostelementresult = mysql_query($hostelementquery) or die('Query failed: ' . mysql_error());			
				if($hostelementresult && mysql_num_rows($hostelementresult))
					{	
					//$hostelement = mysql_fetch_assoc($hostelementresult);
					}
				else 
					{
					$query = "INSERT INTO host_elements(host_id,name) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($element) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());		
					}						
				}		
			}

		$timeframes = $spec['timeframes'];
		if(is_array($timeframes))
			{			
			foreach($timeframes as $timeframe)
				{
					
				// Elements		
		  		$timeframequery = "SELECT * FROM timeframes WHERE name = '" . $timeframe . "'";
				//echo $timeframequery . "<br />";
				$timeframeresult = mysql_query($timeframequery) or die('Query failed: ' . mysql_error());			
				if($timeframeresult && mysql_num_rows($timeframeresult))
					{	
					//$timeframe = mysql_fetch_assoc($timeframeresult);
					}
				else 
					{
					$query = "INSERT INTO timeframes(name) VALUES('" . mysql_real_escape_string($timeframe) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());	
					}	
					
				// Host Elements
		  		$hosttimeframequery = "SELECT * FROM host_timeframes WHERE host_id = " . $host_id . " AND name = '" . $timeframe . "'";
				//echo $hostquery . "<br />";
				$hosttimeframeresult = mysql_query($hosttimeframequery) or die('Query failed: ' . mysql_error());			
				if($hosttimeframeresult && mysql_num_rows($hosttimeframeresult))
					{	
					//$hosttimeframe = mysql_fetch_assoc($hosttimeframeresult);
					}
				else 
					{
					$query = "INSERT INTO host_timeframes(host_id,name) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($timeframe) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());		
					}						
				}	
			}

		$metrics = $spec['metrics'];
		if(is_array($metrics))
			{			
			foreach($metrics as $metric)
				{
					
				// Elements		
		  		$metricquery = "SELECT * FROM metrics WHERE name = '" . $metric . "'";
				//echo $metricquery . "<br />";
				$metricresult = mysql_query($metricquery) or die('Query failed: ' . mysql_error());			
				if($metricresult && mysql_num_rows($metricresult))
					{	
					//$metric = mysql_fetch_assoc($metricresult);
					}
				else 
					{
					$query = "INSERT INTO metrics(name) VALUES('" . mysql_real_escape_string($metric) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());	
					}	
					
				// Host Elements
		  		$hostmetricquery = "SELECT * FROM host_metrics WHERE host_id = " . $host_id . " AND name = '" . $metric . "'";
				//echo $hostquery . "<br />";
				$hostmetricresult = mysql_query($hostmetricquery) or die('Query failed: ' . mysql_error());			
				if($hostmetricresult && mysql_num_rows($hostmetricresult))
					{	
					//$hostmetric = mysql_fetch_assoc($hostmetricresult);
					}
				else 
					{
					$query = "INSERT INTO host_metrics(host_id,name) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($metric) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());		
					}						
				}	
			}

		$geos = $spec['geo'];
		if(is_array($geos))
			{		
			foreach($geos as $geo)
				{
					
				// Elements		
		  		$geoquery = "SELECT * FROM geo WHERE name = '" . $geo . "'";
				//echo $geoquery . "<br />";
				$georesult = mysql_query($geoquery) or die('Query failed: ' . mysql_error());			
				if($georesult && mysql_num_rows($georesult))
					{	
					//$geo = mysql_fetch_assoc($georesult);
					}
				else 
					{
					$query = "INSERT INTO geo(name) VALUES('" . mysql_real_escape_string($geo) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());	
					}	
					
				// Host Elements
		  		$hostgeoquery = "SELECT * FROM host_geo WHERE host_id = " . $host_id . " AND name = '" . $geo . "'";
				//echo $hostquery . "<br />";
				$hostgeoresult = mysql_query($hostgeoquery) or die('Query failed: ' . mysql_error());			
				if($hostgeoresult && mysql_num_rows($hostgeoresult))
					{	
					//$hostgeo = mysql_fetch_assoc($hostgeoresult);
					}
				else 
					{
					$query = "INSERT INTO host_geo(host_id,name) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($geo) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());		
					}						
				}		
			}

		$limits = $spec['limits'];
		if(is_array($limits))
			{		
			foreach($limits as $limit)
				{
					
				// Elements		
		  		$limitsquery = "SELECT * FROM limits WHERE name = '" . $limit . "'";
				//echo $limitsquery . "<br />";
				$limitsresult = mysql_query($limitsquery) or die('Query failed: ' . mysql_error());			
				if($limitsresult && mysql_num_rows($limitsresult))
					{	
					//$limits = mysql_fetch_assoc($limitsresult);
					}
				else 
					{
					$query = "INSERT INTO limits(name) VALUES('" . mysql_real_escape_string($limit) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());	
					}	
					
				// Host Elements
		  		$hostlimitsquery = "SELECT * FROM host_limits WHERE host_id = " . $host_id . " AND name = '" . $limit . "'";
				//echo $hostquery . "<br />";
				$hostlimitsresult = mysql_query($hostlimitsquery) or die('Query failed: ' . mysql_error());			
				if($hostlimitsresult && mysql_num_rows($hostlimitsresult))
					{	
					//$hostlimits = mysql_fetch_assoc($hostlimitsresult);
					}
				else 
					{
					$query = "INSERT INTO host_limits(host_id,name) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($limit) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());		
					}						
				}			
			}

		$resources = $spec['resources'];
		if(is_array($resources))
			{		
			foreach($resources as $resource)
				{
					
				// Elements		
		  		$resourcesquery = "SELECT * FROM resources WHERE name = '" . $resource . "'";
				//echo $resourcesquery . "<br />";
				$resourcesresult = mysql_query($resourcesquery) or die('Query failed: ' . mysql_error());			
				if($resourcesresult && mysql_num_rows($resourcesresult))
					{	
					//$resources = mysql_fetch_assoc($resourcesresult);
					}
				else 
					{
					$query = "INSERT INTO resources(name) VALUES('" . mysql_real_escape_string($resource) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());	
					}	
					
				// Host Elements
		  		$hostresourcesquery = "SELECT * FROM host_resources WHERE host_id = " . $host_id . " AND name = '" . $resource . "'";
				//echo $hostquery . "<br />";
				$hostresourcesresult = mysql_query($hostresourcesquery) or die('Query failed: ' . mysql_error());			
				if($hostresourcesresult && mysql_num_rows($hostresourcesresult))
					{	
					//$hostresources = mysql_fetch_assoc($hostresourcesresult);
					}
				else 
					{
					$query = "INSERT INTO host_resources(host_id,name) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($resource) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());		
					}						
				}	
			}

		$extensions = $spec['extensions'];
		if(is_array($extensions))
			{		
			foreach($extensions as $extension)
				{
					
				// Elements		
		  		$extensionsquery = "SELECT * FROM extensions WHERE name = '" . $extension . "'";
				//echo $extensionsquery . "<br />";
				$extensionsresult = mysql_query($extensionsquery) or die('Query failed: ' . mysql_error());			
				if($extensionsresult && mysql_num_rows($extensionsresult))
					{	
					//$extensions = mysql_fetch_assoc($extensionsresult);
					}
				else 
					{
					$query = "INSERT INTO extensions(name) VALUES('" . mysql_real_escape_string($extension) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());	
					}	
					
				// Host Elements
		  		$hostextensionsquery = "SELECT * FROM host_extensions WHERE host_id = " . $host_id . " AND name = '" . $extension . "'";
				//echo $hostquery . "<br />";
				$hostextensionsresult = mysql_query($hostextensionsquery) or die('Query failed: ' . mysql_error());			
				if($hostextensionsresult && mysql_num_rows($hostextensionsresult))
					{	
					//$hostextensions = mysql_fetch_assoc($hostextensionsresult);
					}
				else 
					{
					$query = "INSERT INTO host_extensions(host_id,name) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($extension) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());		
					}						
				}	
			}

		$plans = $spec['plans'];
		if(is_array($plans))
			{			
			foreach($plans as $key => $value)
				{
					
				$plan_name = $key;
				
				//var_dump($value);
				$plan_description = $value['description'];
				$plan_entries = $value['entries'];
				$plan_elements = $value['elements'];			
													
				// Host Elements
		  		$planquery = "SELECT * FROM host_plans WHERE host_id = " . $host_id . " AND name = '" . $plan_name . "'";
				//echo $planquery . "<br />";
				$planresults = mysql_query($planquery) or die('Query failed: ' . mysql_error());			
				if($planresults && mysql_num_rows($planresults))
					{	
					$planresult = mysql_fetch_assoc($planresults);
					$host_plan_id = $planresult['host_plan_id'];
					}
				else 
					{
					$query = "INSERT INTO host_plans(host_id,name) VALUES(" . mysql_real_escape_string($host_id) . ",'" . mysql_real_escape_string($plan_name) . "')";
					//echo $query . "<br />";
					mysql_query($query) or die('Query failed: ' . mysql_error());	
					$host_plan_id = mysql_insert_id();	
					}
					
				foreach($plan_entries as $entry)
					{
					//var_dump($entry);
					$entry_label = $entry['label'];	
					$entry_description = $entry['description'];
					$entry_metric = $entry['metric'];
					$entry_limit = $entry['limit'];
					$entry_one = $entry['one'];
					$entry_two = $entry['two'];
					$entry_unit = $entry['unit'];
					
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
					}	
					
				foreach($plan_elements as $element)
					{
								
			  		$entryquery = "SELECT * FROM host_plans_elements WHERE host_plan_id = " . $host_plan_id . " AND name = '" . $element . "'";
					//echo $entryquery . "<br />";
					$entryresults = mysql_query($entryquery) or die('Query failed: ' . mysql_error());			
					if($entryresults && mysql_num_rows($entryresults))
						{	
						//$entryresult = mysql_fetch_assoc($entryresults);
						}
					else 
						{
						$query = "INSERT INTO host_plans_elements(host_plan_id,name) VALUES(" . mysql_real_escape_string($host_plan_id) . ",'" . mysql_real_escape_string($element) . "')";
						//echo $query . "<br />";
						mysql_query($query) or die('Query failed: ' . mysql_error());	
						}						
						
					}																		
				}
			}	
		}

	$ReturnObject = $spec;

	//$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>