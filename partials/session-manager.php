<?php
// For Debugging
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 'On');

if (!isset($_SESSION)) {
    session_start();
}

// Check if the employer is logged in
if (isset($_SESSION['loggedin']) && isset($_SESSION['employer']) && isset($_SESSION['email']) && $_SESSION['employer'] == 1) {
    $result = $obj->fetchConditionally("employers", "email_id", $_SESSION['email']);
    $student_control = 0;
    $employer_control = 1;

    foreach ($result as $employer) {
        $employer_id = $employer['id'];
        $email = $employer['email_id'];
        $first_name = $employer['first_name'];
        $last_name = $employer['last_name'];
        $company_name = $employer['company_name'];
    }
} elseif (isset($_SESSION['loggedin']) && isset($_SESSION['student']) && isset($_SESSION['email']) && $_SESSION['student'] == 1) {
    $result = $obj->fetchConditionally("students", "email_id", $_SESSION['email']);
    $student_control = 1;
    $employer_control = 0;

    foreach ($result as $student) {
        $student_id = $student['id'];
        $first_name = $student['first_name'];
        $last_name = $student['last_name'];
        $email_id = $student['email_id'];
    }
} else {
    $result = '';
    $student_control = 0;
    $employer_control = 0;
}
