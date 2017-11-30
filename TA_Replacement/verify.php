<?php
	
	session_save_path('/webpages/kwakaba/TA_Replacement/sessions');
	ini_set('session.gc_probability', 1);
	session_start();
	if(isset($_SESSION['role'])){
		echo json_encode($_SESSION['role']);
	}


?>
