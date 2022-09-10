<?php
if (!isset($_SESSION)) {
    session_start();
    session_unset(); 
    session_destroy();

    if (isset($_SESSION['url']))
        $url = $_SESSION['url']; // holds url for last page visited.
    else
        $url = "index.php";

    header("location: $url");
}
