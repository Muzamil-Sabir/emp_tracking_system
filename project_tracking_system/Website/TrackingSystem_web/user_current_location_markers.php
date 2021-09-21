<?php
//require("phpsqlajax_dbinfo.php");
require("db/opendb.php");
function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Opens a connection to a MySQL server



// Select all the rows in the markers table
$query = "SELECT * FROM employees where isactive=1 ";
 $result = $conn->query($query);


header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
foreach ($result as $value){
  // Add to XML document node
  echo '<marker ';
  echo 'id="' . $value['id'] . '" ';
  echo 'name="' . parseToXML($value['name']) . '" ';
  echo 'cordinates_street_address="' . parseToXML($value['cordinates_street_address']) . '" ';
  echo 'cordinates_country="' . parseToXML($value['cordinates_country']) . '" ';
  echo 'updated_at="' . parseToXML(date( 'M d Y g:i A ', strtotime($value['cordinates_updated_at']))) . '" ';
  echo 'lat="' . $value['lat'] . '" ';
  echo 'lng="' . $value['lng'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}

// End XML file
echo '</markers>';

?>