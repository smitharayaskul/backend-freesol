<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'config.php';
session_start();

$data = json_decode(file_get_contents("php://input"), true);

$flip = $data['flip'];
$min = 0.1;
$max = 2.0;
$randomFlip = mt_rand($min * 10, $max * 10) / 10;


function generateRandomString($length = 5) {
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    // First character: must be a letter
    $randomString = $letters[rand(0, strlen($letters) - 1)];

    // Remaining characters: can be letters or numbers
    for ($i = 1; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

$fullString = generateRandomString(5) . "..." . generateRandomString(5);

$sql = "INSERT INTO `flips`(`user_id`, `amount`, `status`) VALUES ('$fullString','$randomFlip','$flip')";
$sqlResult = mysqli_query($conn, $sql);

if ($sqlResult){
    echo json_encode([
        'status' => 'success',
        'message' => "Inserted Successfully"
    ]);
    return;
}