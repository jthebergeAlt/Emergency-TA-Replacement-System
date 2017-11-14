<?php
	require "support.php";

    unset($_SESSION['email']);
    session_unset();
    session_destroy();
    header('location: index.html');
    
?>