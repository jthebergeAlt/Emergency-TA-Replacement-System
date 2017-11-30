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
		$db = openDB();
		$ta_query = mysqli_query($db, "SELECT first_name, last_name FROM TA");
		
		if(!$ta_query){
			echo("Error description: " . mysqli_error($db));
			return;
		} else{
			$rows = array();
	   		while ($r = mysqli_fetch_assoc($ta_query)){
				$rows[] = $r;
				}

			echo json_encode($rows);
		}
	}

	

    

?>
