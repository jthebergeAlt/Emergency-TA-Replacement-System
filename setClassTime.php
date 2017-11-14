<?php
	require "support.php";

	$email = $_SESSION['email'];

	$section = mysqli_real_escape_string($db,$_POST['section_name']);
	$day = mysqli_real_escape_string($db,$_POST['Days']);
	$start = mysqli_real_escape_string($db,$_POST['Start_t']);
	$end = mysqli_real_escape_string($db,$_POST['End_t']);



    $db = openDB();
    $class_query = mysqli_query($db, "INSERT INTO SectionTimes(section_name, Days, Start_t, End_t) VALUES ('$section', '$day', '$start','end') ");
    
    if(!mysqli_query($db, $class_query)){
    	echo("Error description: " . mysqli_error($db));
    	return;
    }
    
       
?>