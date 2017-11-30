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


	if(isset($_SESSION['email'])){
		$email = $_SESSION['email'];

		$section = mysqli_real_escape_string($db,$_POST['section_name']);
		$day = $db,$_POST['Days'];
		$start = $_POST['Start_t'];
		$end = $_POST['End_t'];


		$db = openDB();

	
		$section_query = mysqli_query($db, "INSERT IGNORE INTO Sections(section_name) VALUES ('$section')");
		if(!mysqli_query($db, $section_query )){
			echo("Error description: " . mysqli_error($db));
			return;
		}
		
	
		$class_query = mysqli_query($db, "INSERT IGNORE INTO SectionTimes(section_name, Days, Start_t, End_t) VALUES ('$section', '$day', '$start','end') ");
		
		if(!mysqli_query($db, $class_query)){
			echo("Error description: " . mysqli_error($db));
			return;
		}

	}
    
       
?>
