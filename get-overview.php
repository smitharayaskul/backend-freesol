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

$sql = "SELECT * FROM `overview` WHERE status = 'overview'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0){
    $rows = mysqli_fetch_assoc($result);

    echo json_encode([
        'status' => 'success',
        'sol_recovered' => $rows['sols_recovered'],
        'acct_recovered' => $rows['account_recovered'],
        'rebates' => $rows['rebate'],
        'sols_price' => 0.77,
    ]);
    return;
}

echo json_encode([
    'status' => 'success',
    'sol_recovered' => 0,
    'acct_recovered' => 0,
    'rebates' => 0,
    'sols_price' => 0.77
]);