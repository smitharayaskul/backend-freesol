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

$data = json_decode(file_get_contents("php://input"), true);

$amount = $data['sols'];

if (empty($amount)){
    echo json_encode([
        'status' => 'error',
        'message' => "Sols to claim required"
    ]);
    return;
}

if (!preg_match('/^[0-9]+$/', $amount)){
    echo json_encode([
        'status' => 'error',
        'message' => "Invalid number"
    ]);
    return;
}

$check = "SELECT * FROM `claim_sol`";
$checkResult = mysqli_query($conn, $check);

if (mysqli_num_rows($checkResult) > 0){
    $update = "UPDATE `claim_sol` SET `sol`='$amount' WHERE item = 'sols'";
    $updateResult = mysqli_query($conn, $update);

    if ($updateResult){
        echo json_encode([
            'status' => 'success',
            'message' => "Updated Successfully"
        ]);
        return;
    }
}

$sols = "sols";

$insert = "INSERT INTO `claim_sol`(`sol`, `item`) VALUES ('$amount','$sols')";
$insertResult = mysqli_query($conn, $insert);

if ($insertResult){
    echo json_encode([
        'status' => 'success',
        'message' => "Inserted Successfully"
    ]);
    return;
}