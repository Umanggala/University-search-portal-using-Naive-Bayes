<?php

function get_college_reviews($college_name)
{
	$reviews_to_be_displayed=array();
	$reviews_to_be_displayed["college"]=array();
	$reviews_to_be_displayed["faculty"]=array();
	
	
	
	
	$query=$college_name." reviews";
	$query=urlencode($query);
	 $url = "http://ajax.googleapis.com/ajax/services/search/web?v=2.0&key=AIzaSyAnSCkpH7f-la1NLF1RSPTx4aCiNej0Tk8&q=$query&rsz=8";
	$body = file_get_contents($url);
	$json = json_decode($body);
	  
	 for($x=0;$x<8;$x++)
	 {
		  if(isset($json->responseData->results[$x]))
		  {
			  $webpage=$json->responseData->results[$x]->url;
			  echo($webpage."<BR/>");
			  $content=get_url_contents($webpage);
			  $clean_content= preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
			  $clean_content=preg_replace('#<[^>]+>#', '#', $clean_content); //replace html tags by #
			  $paras=explode("#",$clean_content);
			  foreach($paras as $para)
			  {
				  $clean_para=clean_data($para);
				 
				  
					 
					  $probabilities=get_naive_bayes_prob($clean_para);
					  if(str_word_count($para)>5 && ($probabilities['faculty']>=0.2 || $probabilities['college']>=0.2))
					  {
						  echo($para."WORD COUNT:".str_word_count($para)."<BR/>");
						  print_r($probabilities);
						  echo("<BR/><BR/><BR/>");
					  }
				  
			  }
		  }
		  echo("<BR/><BR/><BR/>-----------------------------------------------------------------------------<BR/><BR/><BR/>");
	 }
	 
}
					  
				  				  
				  
				  