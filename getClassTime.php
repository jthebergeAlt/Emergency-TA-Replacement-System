<?php
	require "login.php";

	session_start();


    echo("Made it to the function");

	$class_array = array();
	$class_array = explode(', ', $_POST['classes']) ;

	$rows = array();
	$email = $_SESSION['email'] ;

    $db = openDB();

    print_r($class_array);

    /*
    if( isset($class_array) && is_array($class_array) ) {
    	echo("Classes: " . $class_array);
    	$classList = implode(', ', $class_array);
	    foreach($classList as $class) {
	        // eg. $class = COEN 177
	        $class_query = mysqli_query($db, "SELECT Days, Start_t, End_t FROM SectionTimes WHERE section_name = '$class' ");
	        while ($r = mysqli_fetch_assoc($class_query)){
    			$rows[] = $r;
    		}
	    }
	} else{
		echo("Error description: " . mysqli_error($db));
	}
	*/
    //echo json_encode("CLasses" . $class_array);
	
?>