<?php

	echo("Made it to the functions");

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

	if(isset($_SESSION['email'])){
		$class_array = array();
		$class_array = json_decode($_POST['class_times'], true);

		$rows = array();
		$email = $_SESSION['email'] ;
		echo($email);

		$db = openDB();

		if( is_array($class_array )) {
			
			$delete_query = mysqli_query($db, "DELETE FROM TASchedule WHERE email = '$email'");
		
		
			foreach($class_array as $class_section) {
			    // eg. $class_section = COEN 177_M_2:15pm_5:00pm
			
				$class = explode("_", $class_section);
				$section = $class[0];
				$day = $class[1];
				$start = $class[2];
				$end = $class[3];

			    $class_query = mysqli_query($db, "INSERT INTO TASchedule(email, section_name, day, start_t, end_t) VALUES ('$email', '$section', '$day', '$start', '$end') ");
			}

		
		}

	}

	

	

	

?>
