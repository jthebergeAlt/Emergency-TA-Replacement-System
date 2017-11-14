<?php
	require "support.php";


	session_start();


    $db = openDB();

    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);


    $query = "SELECT * FROM TA WHERE email='$email' AND password='$password'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";

		header('location: scheduling.html');		
        
    }
        
   


?>