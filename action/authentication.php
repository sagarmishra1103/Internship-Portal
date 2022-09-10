<?php
include('../config/db.php');
include('./core.php');

// Create Instance of class
$obj = new dataOperaion;

include('../partials/session-manager.php');

// Authentication for Employer
if (isset($_POST['employer_login']) && isset($_POST['email_id']) && isset($_POST['password']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($obj->con, $_POST['email_id']);
    $password = mysqli_real_escape_string($obj->con, $_POST['password']);

    $result = $obj->fetchOneRowBy("password", "employers", "email_id", $email);
    if (count($result) > 0){
        foreach ($result as $row){
            if (password_verify($password, $row['password'])){
                $_SESSION['student'] = 0;
                // If someone steals the session this variable will help
                $_SESSION['loggedin'] = 1;
                $_SESSION['employer'] = 1;
                $_SESSION['email'] = $email;

                if (isset($_SESSION['url']))
                    $url = $_SESSION['url']; // holds url for last page visited.
                else
                    $url = "../index.php";

                header("location: $url");
            }else{
                $_SESSION['login_status'] = 0;
                header('location: ../employer-auth.php');
            }
        }
    }else{
        $_SESSION['login_status'] = 0;
        header('location: ../employer-auth.php');
    }
}

// Authentication for Student
if (isset($_POST['student_login']) && isset($_POST['email']) && isset($_POST['password']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($obj->con, $_POST['email']);
    $password = mysqli_real_escape_string($obj->con, $_POST['password']);

    $result = $obj->fetchOneRowBy("password", "students", "email_id", $email);
    if (count($result) > 0){
        foreach ($result as $row){
            if (password_verify($password, $row['password'])){
                $_SESSION['employer'] = 0;
                // If someone steals the session this variable will help
                $_SESSION['loggedin'] = 1;
                $_SESSION['student'] = 1;
                $_SESSION['email'] = $email;

                if (isset($_SESSION['url']))
                    $url = $_SESSION['url']; // holds url for last page visited.
                else
                    $url = "../index.php";

                header("location: $url");
            }else{
                $_SESSION['login_status'] = 0;
                header('location: ../student-auth.php');
            }
        }
    }else{
        $_SESSION['login_status'] = 0;
        header('location: ../student-auth.php');
    }
}