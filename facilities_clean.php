<?php
function facilities_clean()
{
	//include 'clean_data.php';
	$content=file_get_contents("grammar/facilities.txt");
	$clean_content=clean_data($content);
	file_put_contents("facilities_clean.txt",$clean_content);
}
?>