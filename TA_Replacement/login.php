<?php
	# database credentials
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

	if(isset($_SESSION['email']) && isset($_SESSION['password'])){
		unset($_SESSION['email']);
		session_unset();
		session_destroy();
		header('location: index.html');
	}

	$login_array = array();
	$login_array = json_decode($_POST['login'], true);

    $email = $login_array["email"];
    $password = $login_array["password"];

	if($email == "admin@scu.edu" && $password == "21232f297a57a5a743894a0e4a801fc3"){
    	$_SESSION['email'] = $login_array["email"] ;
    	$_SESSION['password'] = $login_array["password"];
		$_SESSION['role'] = 'admin';

		echo json_encode($_SESSION['role']);
	} else{
		$_SESSION['email'] = $login_array["email"] ;
    	$_SESSION['password'] = $login_array["password"];

		$db = openDB();
		$query = "SELECT * FROM TA WHERE email='$email' AND password='$password'";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
		    $_SESSION['email'] = $email;
		    $_SESSION['success'] = "You are now logged in";		
		    
			$_SESSION['role'] = 'ta';
			echo json_encode($_SESSION['role']);
		}
	}

    
        
   


?>
