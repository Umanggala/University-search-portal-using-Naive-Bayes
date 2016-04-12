<?php
function get_official_site($college_name)
{
	$query = $college_name." official website";
	$query=urlencode($query);
	$url = "http://ajax.googleapis.com/ajax/services/search/web?v=2.0&key=AIzaSyAnSCkpH7f-la1NLF1RSPTx4aCiNej0Tk8&q=".$query."&rsz=1";
	$body = file_get_contents($url);
	$json = json_decode($body);
	$official_site_link=$json->responseData->results[0]->visibleUrl;
	return $official_site_link;
}
?>