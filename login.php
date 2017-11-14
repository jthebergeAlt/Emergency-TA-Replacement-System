<?php
	require "support.php";


	session_start();

    // $email = "";
    // $password = "";

    $db = openDB();

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);


    $query = "SELECT * FROM TA WHERE email='$email' AND password='$password'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";

		header('location: scheduling.html');		
        
    }
        
   







    /*
    $results = mysqli_query($db, $query);
    

    if (echomysqli_num_rows($results) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: register.php');
    }
        */
    


?>