<?php

	define("DBHOST", "dbserver.engr.scu.edu");
	define("DBUSER", "kwakaba");
	define("DBPASS", "00001096003");
	define("DBNAME", "sdb_kwakaba");



	function openDB()
	{
		$database = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Error" . mysqli_error($database));
		return $database;
	}

	session_save_path('/webpages/kwakaba/TA_Replacement/sessions');
	ini_set('session.gc_probability', 1);
    session_start();

    $username = "";
    $password = "";

    $db = openDB();

    
    $fname = mysqli_real_escape_string($db,$_POST['first_name']);
    $lname = mysqli_real_escape_string($db,$_POST['last_name']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password = mysqli_real_escape_string($db,$_POST['password']);
    $phone = mysqli_real_escape_string($db,$_POST['phone']);

    $sql = "INSERT INTO TA (first_name,last_name, email, password, phone) VALUES ('$fname','$lname','$email','$password','$phone')";
    mysqli_query($db, $sql);
    $_SESSION['email'] = $email;
    $_SESSION['success'] = "You are logged in successfully!";
    echo "Login successful";
    header('location: index.html');
        
    

?>
