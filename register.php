<?php

require "support.php";

session_start();

    $username = "";
    $password = "";
    $errors = array();

    $db = openDB();

    if(isset($_POST['register_ta'])){
        $fname = mysqli_real_escape_string($_POST['fname']);
        $lname = mysqli_real_escape_string($_POST['lname']);
        $email = mysqli_real_escape_string($_POST['email']);
        $password = mysqli_real_escape_string($_POST['password']);
        $phone = mysqli_real_escape_string($_POST['phone']);

        $sql = "INSERT OR IGNORE INTO TA (first_name,last_name, email, password, phone) VALUES ('$fname','$lname','$email','$password','$phone')";
        mysqli_query($db, $sql);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are logged in successfully!";
        header('location: scheduler.php');
        
    }

    //echo json_encode(array("status" => SUCCESS));
?>