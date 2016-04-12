<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
function get_url_contents($location)
{
	$ch = curl_init($location);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                                                                                        'Accept: application/json'));
	curl_setopt($ch, CURLOPT_ENCODING ,"");
	$r = curl_exec($ch);
	curl_close($ch);
	//echo mb_detect_encoding($r);
	$r = mb_convert_encoding($r,'ISO-8859-1','utf-8');
	
	//print_r($r);
	
	//file_put_contents("tsec.txt",$r);
	return $r;
}









/*






$html=file_get_contents("http://www.minglebox.com/college/Thadomal-Shahani-Engineering-College-Mumbai-TSEC-M");


$html=html_entity_decode($html, ENT_HTML401, 'UTF-8');
echo($html);
$dom = new DOMDocument();
$dom->loadHTML($html);		
$xpath = new DOMXPath($dom);
$divContent = $xpath->query('//div[class="instDescription"]');




*/
?>