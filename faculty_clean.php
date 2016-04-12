<?php
function faculty_clean()
{
	//include 'clean_data.php';
	$content=file_get_contents("grammar/faculty.txt");
	$clean_content=clean_data($content);
	file_put_contents("faculty_clean.txt",$clean_content);
}
?>