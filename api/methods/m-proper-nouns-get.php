<?php
$route = '/proper-nouns/';
$app->post($route, function ()  use ($app){

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['text'])){ $text = trim(mysql_real_escape_string($param['text'])); } else { $text = '';}
	$pn = new proper_nouns($punctuation=$pun);
	$propernouns = $pn->get($text);
	$P = array();
	foreach($propernouns as $propernoun)
		{
		//echo $propernoun . "<br />";	
		if(strlen($propernoun)>3)
			{
			array_push($P,$propernoun);
			}
		}

	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($P));
		
	});
?>
