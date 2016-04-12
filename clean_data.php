<?php
include 'remove_stop_words.php';
function clean_data($string)
{
	$content=$string;
	$content_uc=strtoupper($content);
	
	$trimmed=trim($content_uc);
	$trimmed=str_replace("\t"," ",$trimmed);
	$trimmed=str_replace("\n"," ",$trimmed);	
	
	$without_spcl_chars=$trimmed;
	//special characters to be relpaced by a space
	$special_chars1=array(".","!",",",";","-","\"","(",")");
	foreach($special_chars1 as $special_char)
	{
		$without_spcl_chars=str_replace($special_char," ",$without_spcl_chars);
	}
	
	
	//$without_spcl_chars = preg_replace("/[^a-zA-Z0-9]+/", " ", html_entity_decode($without_spcl_chars, ENT_QUOTES));
	$without_spcl_chars = preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags(html_entity_decode($without_spcl_chars)));
	
	$without_extra_spaces=str_replace("  "," ",$without_spcl_chars);
	$without_extra_spaces = preg_replace('/\s+/', ' ', $without_extra_spaces);
	
	$without_stop_words=" ".$without_extra_spaces;
	$without_stop_words=remove_stop_words($without_stop_words);
	
	$final_clean_text=trim($without_stop_words);
	
	return $final_clean_text;
}