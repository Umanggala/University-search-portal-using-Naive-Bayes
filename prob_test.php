<?php
//include 'college_reviews_clean.php';
//include 'faculty_clean.php';
//include 'courses_mix.php';

//college_reviews_clean();
//faculty_clean();
//courses_mix();

//include 'get_words_in_category.php';
//get_total_words_all_categories();

include 'get_counts.php';
$occ=get_occurence_in_category("ENGINEERING","courses_clean.txt");
echo($occ);
?>