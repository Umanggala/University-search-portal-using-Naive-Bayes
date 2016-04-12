<?php


function get_words_in_category($filename)
{
	$content=file_get_contents($filename);
	$number_of_words=str_word_count($content);
	return $number_of_words;	
}

/*
function get_total_words_all_categories()
{
	$total=0;
	$total+=get_words_in_category("courses_clean.txt");
	//echo($total."<BR/>");
	$total+=get_words_in_category("faculty_clean.txt");
	//echo($total."<BR/>");
	$total+=get_words_in_category("college_reviews_clean.txt");
	return $total;
}
*/
function get_occurence($word)
{
	$counts_array=array();
	$occ_courses=0;
	$array_course_words=$_SESSION['words_in_courses'];
	if(isset($array_course_words[$word]))
		$occ_courses=$array_course_words[$word];
		
	$occ_faculty=0;
	$array_faculty_words=$_SESSION['words_in_faculty'];
	if(isset($array_faculty_words[$word]))
		$occ_faculty=$array_faculty_words[$word];
	
	$occ_college_reviews=0;
	$array_college_reviews_words=$_SESSION['words_in_college_reviews'];
	if(isset($array_college_reviews_words[$word]))
		$occ_college_reviews=$array_college_reviews_words[$word];
		
	$occ_facilities=0;
	$array_facilities_words=$_SESSION['words_in_facilities'];
	if(isset($array_facilities_words[$word]))
		$occ_facilities=$array_facilities_words[$word];
		
	$counts_array[0]=$occ_courses;
	$counts_array[1]=$occ_faculty;
	$counts_array[2]=$occ_college_reviews;
	$counts_array[3]=$occ_facilities;
	
	return $counts_array;
	
	
}

function get_permanent_counts()
{
	$count_courses_clean=get_words_in_category("courses_clean.txt");
	$count_faculty_clean=get_words_in_category("faculty_clean.txt");
	$count_facilities_clean=get_words_in_category("facilities_clean.txt");
	$count_college_reviews_clean=get_words_in_category("college_reviews_clean.txt");
	$count_total=$count_courses_clean+$count_faculty_clean+$count_college_reviews_clean+$count_facilities_clean;
	
	
	$pr_courses=$count_courses_clean/$count_total;
	$pr_faculty=$count_faculty_clean/$count_total;
	$pr_facilities=$count_facilities_clean/$count_total;
	$pr_college_reviews=$count_college_reviews_clean/$count_total;
	
	$_SESSION['count_courses_clean']=$count_courses_clean;
	$_SESSION['count_faculty_clean']=$count_faculty_clean;
	$_SESSION['count_facilities_clean']=$count_facilities_clean;
	$_SESSION['count_college_reviews_clean']=$count_college_reviews_clean;
	$_SESSION['count_total']=$count_total;
	
	$_SESSION['pr_courses']=$pr_courses;
	$_SESSION['pr_faculty']=$pr_faculty;
	$_SESSION['pr_facilities']=$pr_facilities;
	$_SESSION['pr_college_reviews']=$pr_college_reviews;
	
	$words_in_courses=array();
	$courses_content_clean=file_get_contents("courses_clean.txt");
	$array_courses_content_clean=explode(" ",$courses_content_clean);
	foreach($array_courses_content_clean as $clean_word)
	{
		if(array_key_exists($clean_word,$words_in_courses))
		{
			$words_in_courses[$clean_word]++;
		}
		else
		{
			$words_in_courses[$clean_word]=1;
		}
	}
	
	
	
	
	$words_in_faculty=array();
	$faculty_content_clean=file_get_contents("faculty_clean.txt");
	$array_faculty_content_clean=explode(" ",$faculty_content_clean);
	foreach($array_faculty_content_clean as $clean_word)
	{
		if(array_key_exists($clean_word,$words_in_faculty))
		{
			$words_in_faculty[$clean_word]++;
		}
		else
		{
			$words_in_faculty[$clean_word]=1;
		}
	}
	
	
	$words_in_college_reviews=array();
	$college_reviews_content_clean=file_get_contents("college_reviews_clean.txt");
	$array_college_reviews_content_clean=explode(" ",$college_reviews_content_clean);
	foreach($array_college_reviews_content_clean as $clean_word)
	{
		if(array_key_exists($clean_word,$words_in_college_reviews))
		{
			$words_in_college_reviews[$clean_word]++;
		}
		else
		{
			$words_in_college_reviews[$clean_word]=1;
		}
	}
	
	
	$words_in_facilities=array();
	$facilities_content_clean=file_get_contents("facilities_clean.txt");
	$array_facilities_content_clean=explode(" ",$facilities_content_clean);
	foreach($array_facilities_content_clean as $clean_word)
	{
		if(array_key_exists($clean_word,$words_in_facilities))
		{
			$words_in_facilities[$clean_word]++;
		}
		else
		{
			$words_in_facilities[$clean_word]=1;
		}
	}
	
	
	$_SESSION['words_in_courses']=$words_in_courses;
	$_SESSION['words_in_faculty']=$words_in_faculty;
	$_SESSION['words_in_college_reviews']=$words_in_college_reviews;
	$_SESSION['words_in_facilities']=$words_in_facilities;
			
}

?>