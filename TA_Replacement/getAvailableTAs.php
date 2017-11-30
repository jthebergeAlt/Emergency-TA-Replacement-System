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
		$class_array = array();
		$class_array = json_decode($_POST['classes'], true);
	
	

		$rows = array();
		$rows2 = array();
		$email = $_SESSION['email'] ;

		$db = openDB();
	

		if( is_array($class_array )) {
			
		
			foreach($class_array as $class) {
			    // eg. $class = COEN 177
				//print_r($class_array);
				$class = explode("_", $class);
				$section = $class[0];
				$day = $class[1];
				$start = $class[2];
				$end = $class[3];

				$email_query = mysqli_query($db,"SELECT email FROM TASchedule WHERE section_name = '$section' AND day = '$day' AND start_t = '$start' AND end_t = '$end' ");
				while ($r = mysqli_fetch_assoc($email_query)){   			
					$new_email = $r["email"];
			
					$ta_query = mysqli_query($db, "SELECT first_name, last_name FROM TA WHERE email = '$new_email' ");

					while ($s = mysqli_fetch_assoc($ta_query)){   		
						//print_r($s);
						$firstName = $s["first_name"];
						$space = " ";
						$lastName = $s["last_name"];
					
						$new_name = $firstName . $space . $lastName . $space . $new_email . $space;
					
					
						if(!in_array($new_name, $rows2)){
							$rows2[] = $new_name;
							$rows[] = array("first_name" => $firstName ,"last_name" => $lastName,"email" => $new_email );
						}


					}

				}
			}
		
		}

		echo json_encode($rows);

	}




    
	
?>
