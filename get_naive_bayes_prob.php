<?php
function get_naive_bayes_prob($clean_para)
{
	
	$count_courses_clean=$_SESSION['count_courses_clean'];
	$count_faculty_clean=$_SESSION['count_faculty_clean'];
	$count_college_reviews_clean=$_SESSION['count_college_reviews_clean'];
	$count_facilities_clean=$_SESSION['count_facilities_clean'];
	$count_total=$_SESSION['count_total'];
	
	$pr_courses=$_SESSION['pr_courses'];
	$pr_faculty=$_SESSION['pr_faculty'];
	$pr_college_reviews=$_SESSION['pr_college_reviews'];
	$pr_facilities=$_SESSION['pr_facilities'];
	
	$pr_para_courses=0.0;
	$pr_para_faculty=0.0;
	$pr_para_college_reviews=0.0;
	$pr_para_facilities=0.0;
	
	$para_count=str_word_count($clean_para);
	
	if($para_count>0)
	{
		$words=explode(" ",$clean_para);
		foreach($words as $word)	
		{
			$occ_of_word=get_occurence($word);
			$occ_in_courses=$occ_of_word[0];	
			$pr_word_courses=$occ_in_courses/$count_courses_clean;
				
			$occ_in_faculty=$occ_of_word[1];	
			$pr_word_faculty=$occ_in_faculty/$count_faculty_clean;	
				
			$occ_in_college_reviews=$occ_of_word[2];	
			$pr_word_college_reviews=$occ_in_college_reviews/$count_college_reviews_clean;
			
			$occ_in_facilities=$occ_of_word[3];	
			$pr_word_facilities=$occ_in_facilities/$count_facilities_clean;
			
			$pr_word=$occ_in_courses+$occ_in_faculty+$occ_in_college_reviews+$occ_in_facilities;
			$pr_word=$pr_word/$count_total;					
			if($pr_word!=0)
			{
				$pr_courses_word=($pr_word_courses*$pr_courses)/$pr_word;
				$pr_faculty_word=($pr_word_faculty*$pr_faculty)/$pr_word;
				$pr_college_reviews_word=($pr_word_college_reviews*$pr_college_reviews)/$pr_word;
				$pr_facilities_word=($pr_word_facilities*$pr_facilities)/$pr_word;	
				
				$pr_para_courses+=$pr_courses_word;
				$pr_para_faculty+=$pr_faculty_word;
				$pr_para_college_reviews+=$pr_college_reviews_word;
				$pr_para_facilities+=$pr_facilities_word;
			}//if($pr_word!=0)
		}//foreach($words as $word)
		
		
		
		$pr_para_courses=$pr_para_courses/$para_count;
		$pr_para_faculty=$pr_para_faculty/$para_count;
		$pr_para_college_reviews=$pr_para_college_reviews/$para_count;
		$pr_para_facilities=$pr_para_facilities/$para_count;
		
			
	}//if($para_count>0)
	
	$prob_array=array();
	$prob_array['courses']=$pr_para_courses;
	$prob_array['faculty']=$pr_para_faculty;
	$prob_array['college']=$pr_para_college_reviews;
	$prob_array['facilities']=$pr_para_facilities;
	
	
	return $prob_array;
}//end of function
