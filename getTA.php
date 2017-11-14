<?php
	require "support.php";


	$db = openDB();
    $ta_query = mysqli_query($db, "SELECT first_name, last_name FROM TA");
    
    if(!$ta_query){
    	echo("Error description: " . mysqli_error($db));
    	return;
    } else{
    	$rows = array();
   		while ($r = mysqli_fetch_assoc($ta_query)){
    		$rows[] = $r;
    		}

		echo json_encode($rows);
    }

    

?>