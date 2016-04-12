<?php
function college_reviews_clean()
{
	//include 'clean_data.php';
	$content=file_get_contents("grammar/college_reviews.txt");
	$clean_content=clean_data($content);
	file_put_contents("college_reviews_clean.txt",$clean_content);
}
?>