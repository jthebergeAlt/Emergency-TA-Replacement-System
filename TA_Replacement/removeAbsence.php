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

	$db = openDB();	
	if(isset($_SESSION['email'])){
		$object_array = array();
		$object_array = json_decode($_POST['absences'], true);

		if(is_array($object_array)){

			foreach($object_array as $object){
				print_r($object);
				//echo($object["date"]);

				$date = $object["date"];
				$fname = $object["first_name"];
				$lname = $object["last_name"];
				$email = $object["email"];
				$section = $object["section_name"];
				$day = $object["day"];
				$start = $object["start_t"];
				$end = $object["end_t"];
				$reason = $object["reason"];

				$delete_query = mysqli_query($db, "DELETE FROM TAAbsence WHERE date = '$date' AND f_name = '$fname' AND l_name = '$lname' AND email = '$email' AND section_name = '$section' AND  Days = '$day' AND Start_t = '$start' AND End_t = '$end' AND Reason = '$reason' ");
			
			}


		}
		
	}	

?>
