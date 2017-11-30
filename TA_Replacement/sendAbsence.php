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

		$s_date = "";
		$s_fname = "";
		$s_lname = "";
		$s_email = "";
		$s_section = "";
		$s_day = "";
		$s_start = "";
		$s_end = "";
		$s_reason = "";
		$space = " ";

	
		$times_array = array();
		$dates_array = array();
		$search_array = array();

		$times_array = json_decode($_POST['times'], true);
		$dates_array = json_decode($_POST['dates'], true);
		$reason = json_decode($_POST['reason'], true);

		$rows = array();
		$email = $_SESSION['email'] ;

		$db = openDB();

		$search_query = mysqli_query($db, "SELECT date, f_name, l_name, email, section_name, Days, Start_t, End_t, Reason FROM TAAbsence ");
		while ($t = mysqli_fetch_assoc($search_query)){

			$s_date = $t["date"];
			$s_fname = $t["f_name"];
			$s_lname = $t["l_name"];
			$s_email = $t["email"];
			$s_section = $t["section_name"];
			$s_day = $t["Days"];
			$s_start = $t["Start_t"];
			$s_end = $t["End_t"];
			$s_reason = $t["Reason"];

			$query_value = $s_date . $space . $s_fname . $space . $s_lname . $space . $s_section . $space . $s_day . $space . $s_start . $space . $s_end . $space;
			if(!in_array($query_value, $search_array)){
				$search_array[] = $query_value;
			}

		}

	

		$ta_query = mysqli_query($db, "SELECT first_name, last_name FROM TA WHERE email = '$email' ");
		while ($s = mysqli_fetch_assoc($ta_query)){   		
				
			$firstName = $s["first_name"];
			$lastName = $s["last_name"];
		

			$fname = $firstName . $space;
			$lname = $lastName . $space;



		
			if( is_array($times_array) && is_array($dates_array)) {
			
	
				foreach($dates_array as $date){
		
					foreach($times_array as $time) {
					  
						$class = explode("_", $time);
						$section = $class[0];
						$day = $class[1];
						$start = $class[2];
						$end = $class[3];


						$new_value = $date . $space . $fname . $space . $lname . $space . $section . $space . $day . $space . $start . $space . $end . $space;
						if(!in_array($new_value, $search_array)){
							$class_query = mysqli_query($db, "INSERT INTO TAAbsence(date, f_name, l_name, email, section_name, Days, Start_t, End_t, Reason) VALUES ('$date', '$fname', '$lname', '$email', '$section', '$day', '$start', '$end', '$reason') ");

						}


					}
		

				}

	
			}

	

		}
	}

	

	
?>
