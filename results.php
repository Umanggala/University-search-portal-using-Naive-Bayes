<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
ini_set('max_execution_time', 200);
$college_name=$_POST['search'];
include 'clean_data.php';
include 'college_reviews_clean.php';
include 'courses_mix.php';
include 'faculty_clean.php';
include 'get_counts.php';
include 'get_courses_official_3.php';
include 'get_naive_bayes_prob.php';
include 'get_official_site.php';
include 'get_url_contents.php';
include 'get_college_address.php';

get_permanent_counts();

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<div class="header">
<img src="images/HEADER.jpg" />
</div>
<body >
<div class="back" style="background-image: url(images/COLLAGE2.jpg);background-repeat:repeat;clear:both">
<div class="name" style="color:#9FC"><h2> <?php echo("Results for : \"".strtoupper($college_name)."\" "); ?> </h2></div>
<br /><br />
<div class = "table1" style="color:#FFFFFF;">
<table border="1" style="width:1200px">

<?php
$address=get_college_address($college_name);
if(isset($address) && $address!="")
{
	echo("
	<tr>
	<td style=\"width:200px\"><h3>INSTITUTION NAME AND ADDRESS</h3></td>
	<td style=\"width:auto\">
	".$address."
	</td>
	</tr>
	");
}

?>


<?php
$official_site_link=get_official_site($college_name);

if(isset($official_site_link) && $official_site_link!="")
{
	echo("
		<tr>
		<td style=\"width:200px\"><h3>OFFICIAL WEBSITE</h3></td>
		<td style=\"width:auto\">
	
		<a href=\"".$official_site_link."\">
			".$official_site_link."
		</a>
		</td>
		</tr>
		");
}
?>



<?php
if(isset($_POST['courses']))
{
	$courses=get_courses_official_3($official_site_link);
	echo("
	<tr>
  <td style=\"width:200px\"><h3>COURSES</h3></td>
  
  <td style=\"width:auto\">
  ");
  
  foreach($courses as $course=>$depts)
  {
	  echo("	    
  		<h3>".$course."</h3>
		<ul>
		");
		
		foreach($depts as $dept)
		{
			echo("  				
  				<li>".$dept."</li>
				");
		}
		echo("</ul>
		");
  }
  echo
  ("
  		</td>
		</tr>
	");
}
?>
  				 
  
  
  

<tr>
  <td style="width:200px">Faculty Reviews</td>
  <td style="width:auto">Faculty of this college is good.</td> 
</tr>
</table>

</div>
</div>
</body>
</html>

