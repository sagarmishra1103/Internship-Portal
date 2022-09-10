<?php
if (!isset($_SESSION)) {
    session_start();
}
 // Check if the employer is logged in
 if(isset($_SESSION['loggedin']) && isset($_SESSION['student']) && isset($_SESSION['email']) && $_SESSION['student'] == 1){
    $result = $obj->fetchConditionally("students", "email_id", $_SESSION['email']);
    $student_control = 1;
    $employer_control = 0;

    foreach ($result as $student) {
        $student_id = $student['id'];
        $first_name = $student['first_name'];
        $last_name = $student['last_name'];
        $email_id = $student['email_id'];
    }
}else{
    header('location: index.php');
 }