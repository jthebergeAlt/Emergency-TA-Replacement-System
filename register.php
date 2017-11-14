<?php

require "support.php";

session_start();

    $username = "";
    $password = "";

    $db = openDB();

    
    $fname = mysqli_real_escape_string($db,$_POST['first_name']);
    $lname = mysqli_real_escape_string($db,$_POST['last_name']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password = mysqli_real_escape_string($db,$_POST['password']);
    $phone = mysqli_real_escape_string($db,$_POST['phone']);

    echo $fname;
    echo $lname;
    echo $email;
    echo $password;
    echo $phone;

    $sql = "INSERT INTO TA (first_name,last_name, email, password, phone) VALUES ('$fname','$lname','$email','$password','$phone')";
    mysqli_query($db, $sql);
    $_SESSION['email'] = $email;
    $_SESSION['success'] = "You are logged in successfully!";
    echo "Login successful";
    header('location: index.php');
        
    

    //echo json_encode(array("status" => SUCCESS));
?>