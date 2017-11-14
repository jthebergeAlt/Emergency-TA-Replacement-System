<?php
	require "support.php";

	$rows = array();
	$email = $_SESSION['email'];

    $db = openDB();
    $class_query = mysqli_query($db, "SELECT section_name FROM AllowedSections WHERE ta_email = '$email' ");
    
    if(!$class_query){
    	echo("Error description: " . mysqli_error($db));
    	return;
    } else{
    	while ($r = mysqli_fetch_assoc($class_query)){
    		$rows[] = $r;
    	}

		echo json_encode($rows);
    }

    
    
?>