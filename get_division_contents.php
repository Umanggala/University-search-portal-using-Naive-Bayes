<?php


/*



*/
//$html is the entire html code
//$tag_type defines whether u need class or division content
//$tag_name is the name of the class or id

function get_division_contents($html,$tag_type,$tag_name)
{
	$doc = new DOMDocument();
	$doc->strictErrorChecking = false;
	$doc->recover=true;
	@$doc->loadHTML("<html><body>".$html."</body></html>");
	
	$xpath = new DOMXpath($doc);
	$xpath_tag=$tag_type.'=\"'.$tag_name.'\"';
	$elements = $xpath->query('//div[@'.$tag_type.'="'.$tag_name.'"]/*');
	
	$result="";
	if (!is_null($elements))
	{
		/*
	   foreach ($elements as $element) 
	   {
		   print_r($element);
		   
		  //echo "<br/>[". $element->nodeName. "]";
		  $nodes = $element->childNodes;
		  $result.=" ";
		  foreach ($nodes as $node) 
		  {
			  $result.=(" ".$node->nodeValue." ");		 
			 //echo $node->nodeValue. "\n";
		 }
		 
		 
	   }
	   */
	   
	   foreach ($xpath->query('//div[@'.$tag_type.'="'.$tag_name.'"]/*') as $node)
			{
				$result .= $doc->saveXML($node);
			}
	 }
	 
	 return $result;
}
 
 
 
 
 ?>