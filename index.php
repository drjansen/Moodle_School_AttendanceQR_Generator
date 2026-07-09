<?php
require_once(__DIR__.'/../../config.php');
require_login();

$PAGE->set_url(new moodle_url('/local/attendanceqr/index.php'));
$PAGE->set_title('Attendance QR Code');
$PAGE->set_heading('Attendance QR Code');

global $USER;
// Example hardcoded values; replace as needed for real context
$school_id = 1;
//$period_id = 1;
//$course_period_id = 1;
$school_date = date('Y-m-d');

echo $OUTPUT->header();
echo "<h2>Attendance QR Code</h2>";
echo "<p>Welcome, <strong>{$USER->firstname} {$USER->lastname}</strong> (User ID: {$USER->id})</p>";
echo '<img id="qrimg" src="qr_image.php" width="300" alt="QR Code" />';
echo "<p>Scan this QR for attendance.<br/>";
//echo "<small>QR code refreshes every 10 seconds.</small></p>";
echo $OUTPUT->footer();
?>

<script>
setInterval(function() {
    document.getElementById('qrimg').src = 'qr_image.php?_=' + Date.now();
}, 5000); // Refresh every 5 seconds
</script>
