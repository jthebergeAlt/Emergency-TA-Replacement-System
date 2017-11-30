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
		$rows = array();
		$email = $_SESSION['email'];

		if($email == "admin@scu.edu"){
			$db = openDB();

			$class_query = mysqli_query($db, "SELECT section_name FROM Sections");
		
			if(!$class_query){
				echo("Error description: " . mysqli_error($db));
				return;
			} else{
				while ($r = mysqli_fetch_assoc($class_query)){
					$rows[] = $r;
				}

				echo json_encode($rows);
			}


		}

	}
	
	
    

    
    
?>
