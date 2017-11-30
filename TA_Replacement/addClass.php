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

		$section_array = array();
		$section_time_array = array();


		$section = $_POST["section_name"];
		$day = $_POST["day"];
		$time = explode("-", $_POST["time"]);
		$start = $time[0];
		$end = $time[1];
		$space = " ";

		$new_value = $section . $space . $day . $space . $start . $space . $end . $space;

		echo($new_value);
	
		$db = openDB();

		
		$initial_search_query = mysqli_query($db, "SELECT section_name FROM Sections ");
		while ($s = mysqli_fetch_assoc($initial_search_query)){

			$s_section = $s["section_name"];

			if(!in_array($s_section, $section_array )){
				$section_array[] = $s_section;
			}

		}

		$search_query = mysqli_query($db, "SELECT section_name, Days, Start_t, End_t FROM SectionTimes ");
		while ($t = mysqli_fetch_assoc($search_query)){

			$s_section = $t["section_name"];
			$s_day = $t["Days"];
			$s_start = $t["Start_t"];
			$s_end = $t["End_t"];

			$query_value = $s_section . $space . $s_day . $space . $s_start . $space . $s_end . $space;
			if(!in_array($query_value, $section_time_array )){
				$section_time_array[] = $query_value;
				
			}

		}
		
		if(is_array($section_array) && is_array($section_time_array)){
			if(!in_array($section, $section_array)){
				$class_query = mysqli_query($db, "INSERT INTO Sections(section_name) VALUES ('$section') ");
			}

			if(!in_array($new_value, $section_time_array)){
				$class_query = mysqli_query($db, "INSERT INTO SectionTimes(section_name, Days, Start_t, End_t) VALUES ('$section', '$day' ,'$start' ,'$end') ");
			}

		}







	}

	
    

	

    
    
   
    
       
?>
