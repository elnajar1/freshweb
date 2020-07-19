<object data="http://0.0.0.0:8080/fw/library/files/75/1539532553.pdf"></object>
<embed src="http://0.0.0.0:8080/fw/library/files/75/1539532553.pdf" width="600" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">



<?php
$im = new imagick('/fw/library/files/75/1539532553.pdf[0]');
$im->setImageFormat('jpg');
header('Content-Type: image/jpeg');
echo $im;
var_dump( $im );
/*
$pdfThumb = new imagick();
$pdfThumb->setResolution(10, 10);
$pdfThumb->readImage($filePath . $fileName . $fileExt . '[0]');
$pdfThumb->setImageFormat('jpg');
$fp = $filePath . $fileName . '.jpg';
$pdfThumb->writeImage($fp);
*/
?>