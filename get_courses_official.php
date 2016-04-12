<?php
function get_courses_official($official_site_link)
{
	$start=0;
	courses_mix();
	faculty_clean();
	college_reviews_clean();
	$query="courses";
	$query=urlencode($query);
	
	$url = "http://ajax.googleapis.com/ajax/services/search/web?v=2.0&key=AIzaSyAnSCkpH7f-la1NLF1RSPTx4aCiNej0Tk8&q=".$query."&as_sitesearch=".$official_site_link;
	$body = file_get_contents($url);
	$json = json_decode($body);
	for($x=0;$x<4;$x++)
	{
		if(isset($json->responseData->results[$x]))
		{
			$webpage=$json->responseData->results[$x]->url;
			$content=get_url_contents($webpage);
			$clean_content= preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
			$clean_content=preg_replace('#<[^>]+>#', '#', $clean_content); //replace html tags by #
			$paras=explode("#",$clean_content);
			foreach($paras as $para)
			{
				$clean_para=clean_data($para);
				$probabilities=get_naive_bayes_prob($clean_para);
				if($probabilities['courses']>0.2)
				{
					echo($para."<BR/>");
					print_r($probabilities);
					echo("<BR/><BR/><BR/>");
				}
			}		
		}
	}
	
}
?>

