# Moodle School AttendanceQR Generator

A Moodle local plugin that generates a rotating QR code for student attendance. The QR code payload is signed by a separate backend service and refreshed automatically every few seconds.

## Prerequisites

- Moodle 4.x (requires Moodle `>= 2022041900`)
- PHP 8.1+
- Composer
- A running instance of the Attendance Backend service (see configuration below)

## Installation

1. Clone or copy this directory into `<moodle_root>/local/attendanceqr/`.
2. Install PHP dependencies:
   ```bash
   cd local/attendanceqr
   composer install --no-dev
   ```
3. Log in to Moodle as an admin and visit **Site administration → Notifications** to run the plugin upgrade.

## Configuration

### Backend URL

The plugin calls an external attendance backend to obtain a short-lived nonce for each QR code.  
Before deploying, replace the placeholder in `qr_image.php` with your actual backend endpoint:

```php
// qr_image.php – line 21
$ch = curl_init('https://YOUR_BACKEND_URL/qr-session');
```

Replace `YOUR_BACKEND_URL` with the hostname of your backend service, for example:

```
https://attendance.example.org/qr-session
```

### Hardcoded IDs

The following variables in `qr_image.php` and `index.php` are currently hardcoded for testing and should be replaced with values fetched dynamically from your Moodle course context:

| Variable           | Description                        |
|--------------------|------------------------------------|
| `$school_id`       | Your school/institution identifier |
| `$period_id`       | The timetable period identifier    |
| `$course_period_id`| The course-period mapping ID       |

## Log Files

`attendanceqr_debug.log` is excluded from version control via `.gitignore`.  
Do **not** commit log files – they may contain session nonces or other runtime data.

## License

GPL v3 or later (in accordance with Moodle plugin licensing requirements).
