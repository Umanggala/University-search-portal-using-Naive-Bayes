<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include 'get_url_contents.php';
include 'get_division_contents.php';
ini_set('max_execution_time', 120);
//GET CLEAN DATA SETS
include 'clean_data.php';

include 'courses_mix.php';
courses_mix();
$courses_clean=file_get_contents("courses_clean.txt");

include 'faculty_clean.php';
faculty_clean();
$faculty_clean=file_get_contents("faculty_clean.txt");

include 'college_reviews_clean.php';
college_reviews_clean();
$college_reviews_clean=file_get_contents("college_reviews_clean.txt");




//PROABILITY CALCULATIONS
include 'get_counts.php';
$count_courses_clean=get_words_in_category("courses_clean.txt");
$count_faculty_clean=get_words_in_category("faculty_clean.txt");
$count_college_reviews_clean=get_words_in_category("college_reviews_clean.txt");
$count_total=get_total_words_all_categories();

$pr_courses=$count_courses_clean/$count_total;
$pr_faculty=$count_faculty_clean/$count_total;
$pr_college_reviews=$count_college_reviews_clean/$count_total;


$trusted_string=file_get_contents("trusted_websites.txt");
$trusted_sites=explode("####",$trusted_string);
//print_r($trusted_sites);

$count=0;
$final_courses_paras="";
foreach($trusted_sites as $mix_site)
{	
	$array_mix_site=explode("$$$$",$mix_site);
	$site_link=$array_mix_site[0];
	$class_or_id_string=$array_mix_site[1];
	$array_ids_classes=explode(",",$class_or_id_string);
		
		
		//fetch search results
		$start=0;
		$query="djscoe";
		$query=urlencode($query);
		$url = "http://ajax.googleapis.com/ajax/services/search/web?v=2.0&key=AIzaSyAnSCkpH7f-la1NLF1RSPTx4aCiNej0Tk8&as_sitesearch=".$site_link."&as_epq=courses&q=".$query."&start=".$start;
		$body = file_get_contents($url);
		$json = json_decode($body);
		
		for($x=0;$x<2;$x++)
		{
			if(isset($json->responseData->results[$x]))
			{
				echo("<BR/><BR/><BR/><BR/><BR/>".$json->responseData->results[$x]->url);
				echo("<BR/>");
				
					
				$webpage=$json->responseData->results[$x]->url;
				if($site_link=="http://www.minglebox.com" && $x==0)
					$webpage=$webpage."/courses";
				$web_content=get_url_contents($webpage);
				file_put_contents("web_content".$count.$x.".txt",$web_content);
				foreach($array_ids_classes as $id_or_class)
				{
					$array_id_or_class=explode(":",$id_or_class);
					$tag=$array_id_or_class[0];
					$tag_name=$array_id_or_class[1];
					echo($site_link." ".$tag." ".$tag_name."<BR/>");					
					$div_contents=get_division_contents($web_content,$tag,$tag_name);
					if($div_contents!="")
					{	
						$count++;			
						$filename="result".$count.$x.".txt";
						file_put_contents($filename,$div_contents);			
							
						$content=file_get_contents($filename);
							
						$clean_content= preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);//hide java scripts
						//$res=strip_tags($str);
						$clean_content=preg_replace('#<[^>]+>#', '#', $clean_content); //replace html tags by #
						$paras=explode("#",$clean_content);
					foreach($paras as $para)
					{
						$pr_para_courses=0.0;
						$pr_para_faculty=0.0;
						$pr_para_college_reviews=0.0;
						//echo($para."<BR/>");
						$clean_para=clean_data($para);
						$para_count=str_word_count($clean_para);
						if($para_count>0)
						{
							$words=explode(" ",$clean_para);
							foreach($words as $word)
							{
								$occ_in_courses=get_occurence_in_category($word,"courses_clean.txt");	
								$pr_word_courses=$occ_in_courses/$count_courses_clean;
									
								$occ_in_faculty=get_occurence_in_category($word,"faculty_clean.txt");	
								$pr_word_faculty=$occ_in_faculty/$count_faculty_clean;	
									
								$occ_in_college_reviews=get_occurence_in_category($word,"college_reviews_clean.txt");	
								$pr_word_college_reviews=$occ_in_college_reviews/$count_college_reviews_clean;
								
								$pr_word=$occ_in_courses+$occ_in_faculty+$occ_in_college_reviews;
								$pr_word=$pr_word/$count_total;					
								if($pr_word!=0)
								{
									$pr_courses_word=($pr_word_courses*$pr_courses)/$pr_word;
									$pr_faculty_word=($pr_word_faculty*$pr_faculty)/$pr_word;
									$pr_college_reviews_word=($pr_word_college_reviews*$pr_college_reviews)/$pr_word;	
									
									$pr_para_courses+=$pr_courses_word;
									$pr_para_faculty+=$pr_faculty_word;
									$pr_para_college_reviews+=$pr_college_reviews_word;
								}//if($pr_word!=0)
							}//foreach($words as $word)
							
							
							
							$pr_para_courses=$pr_para_courses/$para_count;
							$pr_para_faculty=$pr_para_faculty/$para_count;
							$pr_para_college_reviews=$pr_para_college_reviews/$para_count;
							
							
							if($pr_para_courses>0.7)
							{
								
								echo($para."<BR/>Course:".$pr_para_courses."<BR/>Faculty:".$pr_para_faculty."<BR/>College Reviews:".$pr_para_college_reviews);
								
								$final_courses_paras.=("####".$para);
							}//if($pr_para_courses>0.7)
						}//($para_count>0)
						
						
						
					}//foreach($paras as $para)
					
					echo("-----------<BR/><BR/--------");
					
				}//if(div_contents!='')
				
			}//if(isset($json->responseData->results[$x]))
			
			
		}//for($x=0;$x<count($json->responseData->results);$x++)
		
		
		
		
		/*$dom = new DOMDocument();
		$dom->loadHTML($html);		
		$xpath = new DOMXPath($dom);
		$divContent = $xpath->query('//div[id="product_list"]');*/
		
	}//foreach($array_ids_classes as $id_or_class)	
	
}//foreach($trusted_sites as $mix_site)	


//search in raw course files
echo("FINAL_COURSE_PARAS => ".$final_courses_paras);
$array_final_courses_paras=explode("####",$final_courses_paras);
$course_files=array("grammar/arts.txt","grammar/commerce.txt","grammar/engineering.txt","grammar/law.txt","grammar/medical.txt","grammar/others.txt","grammar/science.txt");

$courses_to_display=array();
foreach($array_final_courses_paras as $course_para)
{
	$course_para=strtoupper($course_para);
	$course_para=trim($course_para);
	foreach($course_files as $file)
	{
		$course_names=file_get_contents($file);
		$arr_course_names=explode(";",$course_names);
		foreach($arr_course_names as $course_name)
		{
			$clean_course_para=clean_data($course_para);
			$clean_course_name=clean_data($course_name);
			similar_text($clean_course_name,$clean_course_para,$percent);
			
			if($clean_course_para!="" &&$clean_course_name!="" && $percent>=90)
			{
				if(!isset($courses_to_display[$file]))
					$courses_to_display[$file]=array();
				array_push($courses_to_display[$file],$course_name);
					
				//echo($course_name."<BR/>");
			}//if(strpos($course_para,$course_name)!== false)
		}//foreach($arr_course_name as $course_name)
	}//foreach($course_files as $file)
	
	
}//foreach($array_final_courses_paras as $course_para)
	
?>