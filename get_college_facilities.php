<?php

function get_college_facilities($college_name)
{
	$facilities_to_be_displayed=array();
	$raw_facilities="";
	$official_site=get_official_site($college_name);
	$query="facilities";
	 $url = "http://ajax.googleapis.com/ajax/services/search/web?v=2.0&key=AIzaSyAnSCkpH7f-la1NLF1RSPTx4aCiNej0Tk8&q=".$query."&as_sitesearch=".$official_site."&rsz=2";
	$body = file_get_contents($url);
	$json = json_decode($body);
	  
	 for($x=0;$x<2;$x++)
	 {
		  if(isset($json->responseData->results[$x]))
		  {
			  $webpage=$json->responseData->results[$x]->url;
			  $content=get_url_contents($webpage);
			  $clean_content= preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
			  $clean_content=preg_replace('#<[^>]+>#', '#', $content); //replace html tags by #
			  $paras=explode("#",$clean_content);
			  foreach($paras as $para)
			  {
				  $clean_para=clean_data($para);
				  				  
				  $probabilities=get_naive_bayes_prob($clean_para);
				  //if($clean_para!="")
				  //{
				  	//echo($clean_para."<BR/>");
				  	//print_r($probabilities);
				  	//echo("<BR/><BR/><BR/><BR/>");
				  //}
				  if($probabilities['facilities']>0.1)
				  {
					  $clean_para=clean_data($para);
					  $raw_facilities.=(" ".$clean_para);
				  }
				  
				  
			  }
			  
		  }
	 }
	 echo("RAW:".$raw_facilities."<BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/>");
	 $clean_para=clean_data($clean_para);
	 $facilities=explode(";",file_get_contents("grammar/facilities.txt"));
	 foreach($facilities as $facility)
	 {
		 $clean_facility=clean_data($facility);
		 if($raw_facilities!="" && $clean_facility!="" && strpos($raw_facilities,$clean_facility))
		 {
			 array_push($facilities_to_be_displayed,$facility);
		 }
		 
	 }
	 return $facilities_to_be_displayed;
	  
}