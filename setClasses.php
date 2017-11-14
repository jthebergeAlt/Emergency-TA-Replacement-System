<?php
	require "support.php";

	$email = $_SESSION['email'];
	$section = mysqli_real_escape_string($db,$_POST['section_name']);

    $db = openDB();
    $class_query = mysqli_query($db, "INSERT INTO AllowedSections(ta_email, section_name) VALUES ('$email', '$section') ");
    
    if(!mysqli_query($db, $class_query)){
    	echo("Error description: " . mysqli_error($db));
    	return;
    }
    
       
?>