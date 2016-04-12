<?php
function get_college_address($college_name)
{
	$college_name=urlencode($college_name);
	$url="https://maps.googleapis.com/maps/api/place/autocomplete/json?input=$college_name&sensor=false&key=AIzaSyAnSCkpH7f-la1NLF1RSPTx4aCiNej0Tk8&rsz=1";
	
	$body = file_get_contents($url);
	$json = json_decode($body);
	$address=$json->predictions[0]->description;
	return $address;
}