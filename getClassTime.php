<?php
	require "support.php";

	$class_array = array();

	$rows = array();
	$email = $_SESSION['email'];

    $db = openDB();

    if( isset($_POST['classes[]']) && is_array($_POST['classes[]']) ) {
    	$classList = implode(', ', $_POST['classes[]']);
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

    echo json_encode($rows);
	
?>