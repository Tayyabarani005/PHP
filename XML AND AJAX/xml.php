<?php 
$xmldata = "

<note>
<to>Eelaf</to>
<from>Tayyaba</from>
<subject>Meetup plan</subject>
<description>When we will meet each other</description>
</note>
";
$xml = simplexml_load_string($xmldata);
print_r($xml);
echo "<br>";
echo $xml->to . "<br>";
echo $xml->from . "<br>";
echo $xml->subject . "<br>";

//The PHP simplexml_load_file() function is used to read XML data from a file.
?>
