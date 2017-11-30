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
		$ta_array = array();
		$class_array = array();
		$search_array = array();
		$space = " ";

		$ta_array = json_decode($_POST['TAs'], true);
		$class_array = json_decode($_POST['classes'], true);

		echo(count($ta_array));
		echo("\n");

		$db = openDB();

		$search_query = mysqli_query($db, "SELECT ta_email, section_name FROM AllowedSections ");
		while ($t = mysqli_fetch_assoc($search_query)){

			$s_email = $t["ta_email"];
			$s_section = $t["section_name"];

			$query_value = $s_email . $space . $s_section . $space;
			if(!in_array($query_value, $search_array)){
				$search_array[] = $query_value;
				echo($query_value);
				echo("\n");
			}

		}

		if(is_array($ta_array) && is_array($class_array )){
		
		
			foreach($ta_array as $ta){
				$ta_class = explode(" ", $ta);
				$fname = $ta_class[0];
				$lname = $ta_class[1];

				$ta_email = mysqli_query($db, "SELECT email FROM TA WHERE first_name = '$fname' AND  last_name = '$lname'");
				while ($s = mysqli_fetch_assoc($ta_email)){  
					$email = $s["email"];	

					foreach($class_array as $section){
					
						$new_value = $email . $space . $section . $space;
						if(!in_array($new_value, $search_array)){

							echo("New Value" . $space . $new_value );
							echo("\n");
							$class_query = mysqli_query($db, "INSERT INTO AllowedSections(ta_email, section_name) VALUES ('$email', '$section') ");
						}
				
					}

				}
	
			}
		
		}


	}

	

	
    

	

    
    
   
    
       
?>
