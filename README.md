# Moodle School Attendance QR Generator

This plugin provides the **student-facing Moodle attendance QR page** used with the companion tablet app and backend service.

## How it works

This repository is one of **three required components** for the full attendance system:

1. **Moodle QR Generator plugin** (this repository)
2. **Tablet Attendance App** (`drjansen/Moodle_School_Attendance_App`)
3. **Backend service** (`drjansen/Moodle_School_Attendance_App_Backend`)

A student logs into Moodle and clicks the **Attendance** button. That opens the QR attendance page and generates a **dynamic QR code** linked to the student’s logged-in Moodle identity. The QR code changes frequently (approximately every 3 seconds), which helps prevent students from sharing a screenshot or photo of a code with someone else to falsely mark attendance.

The intended workflow is:

- The **student** is physically present at school.
- The student opens Moodle and selects **Attendance**.
- Moodle displays a **rotating, student-specific QR code**.
- A **tablet at school** runs the attendance app with the camera open and ready to scan.
- The app scans the student’s live QR code.
- The **backend service** acts as the middle layer between the tablet app and Moodle.

## Required components

All three repositories are required for the complete solution:

- Moodle QR Generator: `drjansen/Moodle_School_AttendanceQR_Generator`
- Tablet App: `drjansen/Moodle_School_Attendance_App`
- Backend: `drjansen/Moodle_School_Attendance_App_Backend`

## Installation location

This plugin must be placed in the following Moodle path:

```text
moodle/public/local/attendanceqr
```

## Moodle configuration

To make the **Attendance** button appear in Moodle, add the following under **Custom Menu Items**:

```text
Attendance|/local/attendanceqr/index.php|Attendance QR Code
```

## Notes

- The QR code is intended to refresh every few seconds (around 3 seconds).
- The backend is expected to run on the same server as Moodle.
- This repository provides only one part of the overall attendance system.

## License

This project is released under the [MIT No Attribution License (MIT-0)](LICENSE).

> **Provided as-is, without warranty of any kind.** The authors and contributors accept no liability for any damages arising from the use of this software. See the [LICENSE](LICENSE) file for the full terms.

If you find this project useful, a ⭐ star on GitHub is always appreciated — it helps others discover it too.
If you adapt IVY Messenger for your own school or organisation, consider forking the repo and sharing your improvements with the community.
