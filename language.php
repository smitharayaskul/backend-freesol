<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
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

$input = file_get_contents("php://input");
$data = json_decode($input, true);


$sessionSet = $_SESSION['guest_id'];

if ($data['language'] === 'en') {
    $lang = 'zh';
}else{
    $lang = 'en';
}


$sqlCheck = "SELECT * FROM lang WHERE user_id = '$sessionSet'";
$checkResult = mysqli_query($conn, $sqlCheck);

if (mysqli_num_rows($checkResult) > 0){
    $update = "UPDATE `lang` SET `lang`='$lang' WHERE user_id = '$sessionSet'";
    $result = mysqli_query($conn, $update);

    if (!$result){
        echo json_encode([
            'status' => 'error',
            'message' => 'Operation failed',
            'lang' => $lang
        ]);
    }
}else{
    $insert = "INSERT INTO `lang`(`user_id`, `lang`) VALUES ('$sessionSet','$lang')";
    $result = mysqli_query($conn, $insert);

    if (!$result){
        echo json_encode([
            'status' => 'error',
            'message' => 'Operation failed',
            'lang' => $lang
        ]);
    }
}

echo json_encode([
    'status' => 'success',
    'message' => 'Operation successful',
    'lang' => $lang
]);