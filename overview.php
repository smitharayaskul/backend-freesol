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

$solRec = $data['totals']['solsRecovered'];
$acctRec = $data['totals']['accountsRecovered'];
$rebates = $data['totals']['rebates'];


if (empty($solRec) || empty($acctRec) || empty($rebates)){
    echo json_encode([
        'status' => 'error',
        'message' => "All fields required"
    ]);
    return;
}

if (!preg_match('/^[0-9]+$/', $solRec)){
    echo json_encode([
        'status' => 'error',
        'message' => "Invalid number"
    ]);
    return;
}

if (!preg_match('/^[0-9]+$/', $acctRec)){
    echo json_encode([
        'status' => 'error',
        'message' => "Invalid number"
    ]);
    return;
}

if (!preg_match('/^[0-9]+$/', $rebates)){
    echo json_encode([
        'status' => 'error',
        'message' => "Invalid number"
    ]);
    return;
}

$check = "SELECT * FROM `overview`";
$result = mysqli_query($conn, $check);

if (mysqli_num_rows($result) > 0){
    $update = "UPDATE `overview` SET `sols_recovered`='$solRec',`account_recovered`='$acctRec',`rebate`='$rebates' WHERE status = 'overview'";
    $updateResult = mysqli_query($conn, $update);

    if ($updateResult){
        echo json_encode([
            'status' => 'success',
            'message' => "Updated Successfully"
        ]);
        return;
    }
}

$insert = "INSERT INTO `overview`(`sols_recovered`, `account_recovered`, `rebate`, `status`) VALUES ('$solRec','$acctRec','$rebates','overview')";
$insertResult = mysqli_query($conn, $insert);

if ($insertResult){
    echo json_encode([
        'status' => 'success',
        'message' => "Inserted Successfully"
    ]);
    return;
}