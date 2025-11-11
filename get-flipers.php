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

$sql = "SELECT * FROM `flips` ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$flips = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        if (isset($row['created_at'])) {
            $row['created_at'] = gmdate('c', strtotime($row['created_at']));
            // Example output: 2025-11-11T09:42:10Z
        }

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
