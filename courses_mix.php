<?php
function courses_mix()
{
	//include 'clean_data.php';
	$courses='';
	$courses=$courses." ".file_get_contents("grammar/arts.txt");
	$courses=$courses." ".file_get_contents("grammar/commerce.txt");
	$courses=$courses." ".file_get_contents("grammar/engineering.txt");
	$courses=$courses." ".file_get_contents("grammar/law.txt");
	$courses=$courses." ".file_get_contents("grammar/medical.txt");
	$courses=$courses." ".file_get_contents("grammar/others.txt");
	$courses=$courses." ".file_get_contents("grammar/science.txt");
	
	$clean_courses=clean_data($courses);
	file_put_contents("courses_clean.txt",$clean_courses);
}
?>