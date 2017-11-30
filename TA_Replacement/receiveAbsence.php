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

	if(isset($_SESSION['email'] )){
		$db = openDB();
		$absent_query = mysqli_query($db, "SELECT date, f_name, l_name, email, section_name, Days, Start_t, End_t, Reason FROM TAAbsence");
		
		if(!$absent_query){
			echo("Error description: " . mysqli_error($db));
			return;
		} else{
			$rows = array();
	   		while ($r = mysqli_fetch_assoc($absent_query)){
				$date = $r["date"];
				$fname = $r["f_name"];
				$lname = $r["l_name"];
				$email = $r["email"];
				$section = $r["section_name"];
				$day = $r["Days"];
				$start = $r["Start_t"];
				$end = $r["End_t"];
				$reason = $r["Reason"]; 
			
				$rows[] = array("date" => $date ,"first_name" => $fname ,"last_name" => $lname,"email" => $email,"section_name" => $section,"day" => $day,"start_t" => $start,"end_t" => $end,"reason" => $reason );
				}

			echo json_encode($rows);
		}

	}


	

    

?>
