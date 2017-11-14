<?php
	require "support.php";


	session_start();

    // $email = "";
    // $password = "";

    $db = openDB();

    // LOGIN USER
    
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);




    $stmt = $db->stmt_init();
    $query = "SELECT password FROM Login WHERE email ='$email'";
    $stmt->prepare($query);
    $stmt->bind_param("s", $username);

    # attempt to authenticate login credentials
    if ($stmt->execute()) {
        $stmt->bind_result($result);
        if ($stmt->fetch() && password_verify($password, $result)) {
            # valid credentials
            return SUCCESS;
        }
        # invalid credentials
        return INVALID_LOGIN;
    }







    /*
    $results = mysqli_query($db, $query);
    

    if (echomysqli_num_rows($results) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: register.php');
    }
        */
    


?>