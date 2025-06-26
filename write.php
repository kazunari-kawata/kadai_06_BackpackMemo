<?php
$place = $_POST['place'];
$date = $_POST['date'];
$memo = $_POST['memo'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$line = "$place,$date,$memo,$lat,$lng\n";
file_put_contents('./data/data.csv', $line, FILE_APPEND);
header('Location: read.php');
?>