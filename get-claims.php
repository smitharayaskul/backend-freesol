<?php
header("Access-Control-Allow-Origin: https://www.claimfeesol.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'config.php';
session_start();

$sql = "SELECT * FROM `claim_sol` WHERE item = 'sols'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0){
    $rows = mysqli_fetch_assoc($result);

    echo json_encode([
        'status' => 'success',
        'sols' => $rows['sol'],
    ]);
    return;
}

echo json_encode([
    'status' => 'success',
    'sols' => 0,
]);