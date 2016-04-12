<?php
function get_courses_official_2($official_site_link)
{
	$courses_to_display=array();
	$start=0;
	$max=7;
	
	$query="courses+OR+Departments+OR+programmes+OR+academics+OR+faculty+OR+degrees";
	$query=urlencode($query);
	while($start<=$max)
	{
		$url = "http://ajax.googleapis.com/ajax/services/search/web?v=2.0&key=AIzaSyAnSCkpH7f-la1NLF1RSPTx4aCiNej0Tk8&q=".$query."&as_sitesearch=".$official_site_link."&start=".$start;
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
					if($probabilities['courses']>0.8)
					{
						$courses_list_files=array("grammar/arts.txt#ARTS", "grammar/commerce.txt#COMMERCE", "grammar/science.txt#SCIENCE", "grammar/engineering.txt#ENGINEERING", "grammar/others.txt#OTHERS", "grammar/law.txt#LAW", "grammar/medical.txt#MEDICAL");
						foreach($courses_list_files as $file)
						{
							$file_path_and_display=explode("#",$file);
							$file_path=$file_path_and_display[0];
							$file_display_name=$file_path_and_display[1];
			
							$courses=file_get_contents($file_path);
							$courses_split=explode(";",$courses);
							foreach($courses_split as $course)
							{
								$clean_course_name=clean_data($course);
								$clean_course_para=$clean_para;
								similar_text($clean_course_name,$clean_course_para,$percent);
								if($clean_course_para!="" && $clean_course_name!="" && ($percent>90))
								{
									if(!isset($courses_to_display[$file_display_name]))
										$courses_to_display[$file_display_name]=array();
									array_push($courses_to_display[$file_display_name],$course);
								}//if($percent>60 || strpos($clean_course_para,$clean_course_name)!==false)
							}//foreach($courses_split as $course)
						}//foreach($courses_list_files as $file)
					}//if($probabilities['courses']>0.8)
				}//foreach($paras as $para)	
			}//if(isset($json->responseData->results[$x]))
		}//for($x=0;$x<4;$x++)
		$start+=4;
	}//while($start<=$max)
	
	return $courses_to_display;
}//end of function
?>

