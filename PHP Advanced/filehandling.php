<?php

//readfile function

echo 'readfile function'.'<br>';
echo readfile("webdictionary.txt").'<br>';

//fopen function,reading the file

echo 'fopen function'.'<br>';
$myfile = fopen('webdictionary.txt','r') or die ('Unable to open the file');
echo fread($myfile, filesize('webdictionary.txt')).'<br>';
fclose($myfile);

//fopen function, writing into file
echo 'Writing to file'.'<br>';
$myfile1 = fopen('filename.txt','w') or die ('unable to open this file');
$txt = 'Tayyaba';
echo fwrite($myfile1, $txt);
fclose($myfile1); //this will print tayyaba
//But if we again rewrite this whole code then it will erase the previous data so for our previous data hold we use a in our mode 

?>