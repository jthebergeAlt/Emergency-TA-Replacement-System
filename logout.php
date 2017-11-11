<?php
	if(isset($_GET['logout'])){
        unset($_SESSION['email']);
        session_unset();
        session_destroy();
        header('location: login.php');
    }
?>