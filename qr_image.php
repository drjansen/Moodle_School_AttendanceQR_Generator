<?php
require_once(__DIR__.'/../../config.php');
require_login();
header('Content-Type: image/png');
global $USER;

// You can adjust/fetch these params as needed.
$school_id = 1;
$period_id = 1;
$course_period_id = 1;
$school_date = date('Y-m-d H:i:s');

// --- Call Python backend to get QR session nonce ---
function get_qr_session($school_id, $period_id, $course_period_id, $school_date) {
    $data = [
        "school_id" => $school_id,
        "period_id" => $period_id,
        "course_period_id" => $course_period_id,
        "school_date" => $school_date
    ];
    $ch = curl_init('https://attendance.icsportals.org/qr-session');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$session = get_qr_session($school_id, $period_id, $course_period_id, $school_date);
if (!$session || !isset($session['nonce'])) {
    http_response_code(500);
    exit;
}

$payload = json_encode([
    "nonce" => $session['nonce'],
    "school_id" => $school_id,
    //"period_id" => $period_id,
    //"course_period_id" => $course_period_id,
    "school_date" => $school_date,
    "first_name" => $USER->firstname,
    "last_name" => $USER->lastname
]);

require_once __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;

$qrCode = new QrCode(
    data: $payload,
    encoding: new Encoding('UTF-8'),
    errorCorrectionLevel: ErrorCorrectionLevel::Low,
    size: 300,
    margin: 10,
    roundBlockSizeMode: RoundBlockSizeMode::Margin,
    foregroundColor: new Color(0, 0, 0),
    backgroundColor: new Color(255, 255, 255)
);

$writer = new PngWriter();
$result = $writer->write($qrCode);
echo $result->getString();
