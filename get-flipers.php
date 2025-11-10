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

$sql = "SELECT * FROM `flips` ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$flips = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $flips[] = $row; // push each row as array
    }

    echo json_encode([
        'status' => 'success',
        'flips' => $flips
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No flips found'
    ]);
}

mysqli_close($conn);
?>
