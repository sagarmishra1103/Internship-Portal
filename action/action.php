<?php
// For Debugging
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 'On');

if (!isset($_SESSION)) {
    session_start();
}
include('../config/db.php');
include('./core.php');
// Create Instance of class
$obj = new dataOperaion;


// Handle the data submitted for employer registration
if (isset($_POST['add_employer']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $values = array(
        "first_name" => mysqli_real_escape_string($obj->con, strip_tags($_POST['first_name'])),
        "last_name" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['last_name'])),
        "email_id" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['email_id'])),
        "password" =>  password_hash(mysqli_escape_string($obj->con, $_POST['password']), PASSWORD_BCRYPT),
        "company_name" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['company_name'])),
        "company_url" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['company_url'])),
        "mobile" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['mobile'])),
        "about" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['about'])),
    );

    // Check if email is already in database
    $email_result = $obj->fetchOneRowBy("email_id", "employers", "email_id", mysqli_real_escape_string($obj->con, strip_tags($_POST['email_id'])));
    if (count($email_result) > 0) {
        $_SESSION['duplicate_email'] = 1;
        header("location: ../employer-registration.php", http_response_code(400));
        exit(0);
    }

    // Check if mobile number is already in database
    $mobile_result = $obj->fetchOneRowBy("mobile", "employers", "mobile", mysqli_real_escape_string($obj->con, strip_tags($_POST['mobile'])));
    if (count($mobile_result) > 0) {
        $_SESSION['duplicate_mobile'] = 1;
        header("location: ../employer-registration.php", http_response_code(400));
        exit(0);
    }

    if ($obj->insert("employers", $values)) {
        $_SESSION['employer_registration'] = 1;
        header("location: ../employer-registration.php");
    } else {
        $_SESSION['employer_registration'] = 0;
        header("location: ../employer-registration.php");
    }
}


// Handle the data submitted for Student Registration
if (isset($_POST['add_student']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $values = array(
        "first_name" => mysqli_real_escape_string($obj->con, strip_tags($_POST['first_name'])),
        "last_name" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['last_name'])),
        "email_id" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['email'])),
        "password" =>  password_hash(mysqli_escape_string($obj->con, $_POST['password']), PASSWORD_BCRYPT),
        "mobile" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['mobile'])),
        "gender" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['gender'])),
        "projects" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['projects'])),
    );

    /* TODO: The project field can be handled more preciesely by having it's own 
    independent table ontaining fields like duration, role purpose etc can be done later */

    // Check if email is already in database
    $email_result = $obj->fetchOneRowBy("email_id", "students", "email_id", mysqli_real_escape_string($obj->con, strip_tags($_POST['email'])));
    if (count($email_result) > 0) {
        $_SESSION['duplicate_email'] = 1;
        header("location: ../student-register.php", http_response_code(400));
        exit(0);
    }

    // Check if mobile number is already in database
    $mobile_result = $obj->fetchOneRowBy("mobile", "students", "mobile", mysqli_real_escape_string($obj->con, strip_tags($_POST['mobile'])));
    if (count($mobile_result) > 0) {
        $_SESSION['duplicate_mobile'] = 1;
        header("location: ../student-register.php", http_response_code(400));
        exit(0);
    }

    if ($obj->insert("students", $values)) {
        // Entry inserted into the table now get ID of that row
        $last_id = mysqli_insert_id($obj->con);

        $address_fields = array(
            "student_id" => $last_id,
            "address" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['address1'])),
            "address2" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['address2'])),
            "pincode" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['pincode'])),
        );


        if ($obj->insert("address", $address_fields)) {
            $skills = $_POST['skills'];
            for ($i = 0; $i < sizeof($skills); $i++) {
                $skill_values = array(
                    "student_id" => $last_id,
                    "skill_id" => mysqli_real_escape_string($obj->con, strip_tags($skills[$i])),
                );
                $obj->insert("student_skills", $skill_values);
            }

            // Insert Edication values
            $edu_values = array(
                "student_id" => $last_id,
                "highest_edu" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['highest_edu'])),
                "institute" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['institute'])),
                "percentage" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['percentage'])),
                "institute_state" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['institute_state'])),
            );


            $obj->insert("student_education", $edu_values);

            $_SESSION['student_registration'] = 1;
            header("location: ../student-register.php");
        } else {
            $_SESSION['student_registration'] = 0;
            header("location: ../student-register.php");
        }
    } else {
        $_SESSION['student_registration'] = 0;
        header("location: ../student-register.php");
    }
}


// Handle the data submitted for posted internship
if (isset($_POST['add_internship']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $values = array(
        "title" => mysqli_real_escape_string($obj->con, strip_tags($_POST['title'])),
        "start_date" => mysqli_real_escape_string($obj->con, strip_tags($_POST['start_date'])),
        "end_date" => mysqli_real_escape_string($obj->con, strip_tags($_POST['end_date'])),
        "posted_by" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['company_id'])),
        "duration" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['duration'])),
        "stipend" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['stipend'])),
        "duration_week" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['duration_week'])),
        "stipend_week" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['stipend_week'])),
        "about_internship" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['about_internship'])),
        "number_of_interns" =>  mysqli_real_escape_string($obj->con, strip_tags($_POST['number_of_interns'])),
        "who_can" => mysqli_real_escape_string($obj->con, strip_tags($_POST['who_can'])),
        "part_time_allowed" => mysqli_real_escape_string($obj->con, strip_tags($_POST['part_time'])),

    );

    if ($obj->insert("internships", $values)) {

        $internship_id = mysqli_insert_id($obj->con);

        // Insert into the required skills table
        $skills = $_POST['skills'];
        for ($i = 0; $i < sizeof($skills); $i++) {
            $skill_values = array(
                "internship_id" => $internship_id,
                "skill_id" => mysqli_real_escape_string($obj->con, strip_tags($skills[$i])),
            );
            $obj->insert("required_skills", $skill_values);
        }

        $perks = $_POST['perks'];
        for ($i = 0; $i < sizeof($perks); $i++) {
            $perk_values = array(
                "internship_id" => $internship_id,
                "perk_id" => mysqli_real_escape_string($obj->con, strip_tags($perks[$i])),
            );
            $obj->insert("internship_perks", $perk_values);
        }

        $locations = $_POST['locations'];
        for ($i = 0; $i < sizeof($locations); $i++) {
            $location_values = array(
                "internship_id" => $internship_id,
                "location_id" => mysqli_real_escape_string($obj->con, strip_tags($locations[$i])),
            );
            $obj->insert("internship_locations", $location_values);
        }

        $_SESSION['internship_added'] = 1;
        header("location: ../internship-details.php?id=$internship_id");
    } else {
        $_SESSION['internship_added'] = 0;
        header("location: ../post-internship.php");
    }
}

// Apply for an internship
if (isset($_POST['apply']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id']) && isset($_POST['internship_id'])) {
    $student_id = mysqli_real_escape_string($obj->con, strip_tags($_POST['student_id']));
    $internship_id = mysqli_real_escape_string($obj->con, strip_tags($_POST['internship_id']));

    $values = array(
        "student_id" => $student_id,
        "internship_id" => $internship_id,
    );

    if ($obj->insert("applied_internships", $values)) {
        $_SESSION['applied'] = 1;
        header("location: ../internship-details.php?id=$internship_id");
    } else {
        $_SESSION['applied'] = 0;
        header("location: ../post-internship.php");
    }
}

// If the application status is changed
if (isset($_POST['shortlist']) || isset($_POST['in_touch'])  || isset($_POST['selected'])  || isset($_POST['rejected']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['shortlist'])){
        $value = 'Shortlisted';
    }elseif(isset($_POST['in_touch'])){
        $value = 'In Touch';
    }elseif(isset($_POST['rejected'])){
        $value = 'Rejected';
    }elseif(isset($_POST['selected'])){
        $value = 'Selected';
    }

    $student_id = mysqli_real_escape_string($obj->con, strip_tags($_POST['student_id']));
    $internship_id = mysqli_real_escape_string($obj->con, strip_tags($_POST['internship_id']));

    $where = array(
        "student_id" => $student_id,
        "internship_id" => $internship_id,
    );

    $values = array(
        "application_status" => $value,
    );

    if ($obj->update("applied_internships",$where, $values)) { 
        header("location: ../view-application.php?id=$internship_id&s_id=$student_id", http_response_code(200));
    }else{
        header("location: ../view-application.php?id=$internship_id&s_id=$student_id", http_response_code(400));
    }
}

