<?php
if (!isset($_SESSION)) {
    session_start();
}
 // Check if the employer is logged in
if(isset($_SESSION['loggedin']) && isset($_SESSION['employer']) && isset($_SESSION['email']) && $_SESSION['employer'] == 1){
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
 }else{
    header('location: index.php');
 }