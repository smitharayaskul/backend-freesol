<?php

$user = 'iruabigailo27425_mimi';
$password = '09077331043Mira$$';
$database = 'iruabigailo27425_freesol';
$host = 'localhost';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn){
    echo "Error in connection" . mysqli_connect_error();
    return;
}