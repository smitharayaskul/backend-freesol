<?php

header("Access-Control-Allow-Origin: https://www.claimfeesol.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// If it's a preflight request, stop execution early
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Session will last for 7 days (604800 seconds)
ini_set('session.cookie_lifetime', 604800);
ini_set('session.gc_maxlifetime', 604800);

include 'config.php';

session_start();

// If there is no session ID, PHP automatically creates one
if (!isset($_SESSION['guest_id'])) {
    $_SESSION['guest_id'] = uniqid('guest_', true);
}

$sessionSet = $_SESSION['guest_id'];

$sqlCheck = "SELECT * FROM lang WHERE user_id = '$sessionSet'";
$checkResult = mysqli_query($conn, $sqlCheck);

if (mysqli_num_rows($checkResult) > 0){

    $rows = mysqli_fetch_assoc($checkResult);

    echo json_encode([
        'status' => 'success',
        'message' => 'Operation Sucessful',
        'lang' => $rows['lang']
    ]);
}else{
    $insert = "INSERT INTO `lang`(`user_id`, `lang`) VALUES ('$sessionSet','en')";
    $result = mysqli_query($conn, $insert);

    if (!$result){
        echo json_encode([
            'status' => 'success',
            'message' => 'Operation Sucessful',
            'lang' => 'en'
        ]);
    }
}