<?php
include 'clean_data.php';
include 'college_reviews_clean.php';
include 'courses_mix.php';
include 'faculty_clean.php';
include 'facilities_clean.php';
include 'get_counts.php';

courses_mix();
faculty_clean();
college_reviews_clean();
facilities_clean();
get_permanent_counts();
echo($_SESSION['count_college_reviews_clean']);
?>