<?php

require 'upload.inc.php';

$path = UPLOAD_DIR;
$filename = $_SERVER['HTTP_X_FILE_NAME'];
$filesize = $_SERVER['CONTENT_LENGTH'];

$file = "upload/log.txt";
$fo = fopen($file, "w");
fwrite($fo, $path . PHP_EOL);
fwrite($fo, $filename . PHP_EOL);
fwrite($fo, $filesize . PHP_EOL);
fwrite($fo, $path . "/" . $filename . PHP_EOL);

$n = rand(10e16, 10e20);
$random = base_convert($n, 10, 36);

$filetype = explode(".", $filename);
$filext = $filetype[1];

$filename = $random . "." . $filext;



file_put_contents($path . "/" . $filename, file_get_contents("php://input"));

echo $filename;
?>
