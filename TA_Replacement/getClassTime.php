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
		$class_array = array();
		$class_array = json_decode($_POST['classes'], true);

		$rows = array();
		$email = $_SESSION['email'] ;

		$db = openDB();
	

		if( is_array($class_array )) {
			
		
			foreach($class_array as $class) {
			    // eg. $class = COEN 177
			    $class_query = mysqli_query($db, "SELECT section_name, Days, Start_t, End_t FROM SectionTimes WHERE section_name = '$class' ");
			    while ($r = mysqli_fetch_assoc($class_query)){   			
					$rows[] = $r;
				}
			}
		
		} else{
			echo("Error description: " . mysqli_error($db));
		}


		echo json_encode($rows);

	}


	
	
?>
