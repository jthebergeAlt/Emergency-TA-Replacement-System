<?php
	require "support.php";


	session_start();

    $email = "";
    $password = "";

    $db = openDB();

    // LOGIN USER
    if (isset($_POST['login_user'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

    
        $query = "SELECT * FROM Login WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: scheduler.php');
        }
        
    }


?>