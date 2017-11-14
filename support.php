<?php 
# response codes
define("SUCCESS", 0);
define("SERVER_ERROR", 1);
define("INVALID_LOGIN", 2);
define("INVALID_ARGS", 3);

# database credentials
define("DBHOST", "dbserver.engr.scu.edu");
define("DBUSER", "kwakaba");
define("DBPASS", "00001096003");
define("DBNAME", "sdb_kwakaba");


function openDB()
{
    $database = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Error" . mysqli_error($database));
    return $database;
}
/*
###########################################################################################################

function sqlVerifyLogin()
{

    session_start();

    $email = "";
    $password = "";

    $db = openDB();

    // LOGIN USER
    if (isset($_POST['login_user'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

    
        $query = "SELECT * FROM Login WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: scheduler.php');
        }
        
    }

}

###########################################################################################################
function logout(){
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['email']);
        header('location: login.php');
    }
}

###########################################################################################################

function sqlDeleteSections(){
    $db = openDB();
    $stmt_insert = $db->stmt_init();
    $stmt_delete = $db->stmt_init();

    $stmt_delete->prepare("DELETE FROM Available WHERE email=?");
    $stmt_delete->bind_param("s", $_POST["email"]);
    if (!$stmt_delete->execute()) {
        echo json_encode(array("status" => SERVER_ERROR, "message" => "failed to delete sections"));
        return;
    }

    mysqli_close($db);

    echo json_encode(array("status" => SUCCESS));
}

###########################################################################################################

function sqlAllTAs(){
    $db = openDB();
    $stmt = $db->stmt_init();
    $stmt->prepare("SELECT first_name, last_name lname FROM TA");
    

    if (!$stmt->execute()) {
        echo json_encode(array("status" => SERVER_ERROR, "message" => "failed to get all TAs"));
        return;
    }

    $data = array();
    $stmt->bind_result($fname, $lname);
    while ($stmt->fetch()) {
        $data[] = array("fname" => $fname, "lname" => $lname);
    }

    mysqli_close($db);

    echo json_encode(array("status" => SUCCESS, "result" => $data), JSON_PRETTY_PRINT);

}

###########################################################################################################

function sqlTASchedule(){
    $db = openDB();
    $stmt = $db->stmt_init();
    $stmt->prepare("SELECT section_id FROM Available WHERE email=?");
    $stmt->bind_param("s", $_POST["email"]);

    if (!$stmt->execute()) {
        echo json_encode(array("status" => SERVER_ERROR, "message" => "failed to get TA Schedule"));
        return;
    }

    $data = array();
    $stmt->bind_result($section);
    while ($stmt->fetch()) {
        $data[] = array("section_id" => $section);
    }

    mysqli_close($db);

    echo json_encode(array("status" => SUCCESS, "result" => $data), JSON_PRETTY_PRINT);
}

###########################################################################################################

function sqlInsertTA(){

    session_start();

    $username = "";
    $password = "";
    $errors = array();

    $db = openDB();

    if(isset($_POST['register_ta'])){
        $fname = mysqli_real_escape_string($_POST['fname']);
        $lname = mysqli_real_escape_string($_POST['lname']);
        $email = mysqli_real_escape_string($_POST['email']);
        $password = mysqli_real_escape_string($_POST['password']);
        $phone = mysqli_real_escape_string($_POST['phone']);

        $sql = "INSERT OR IGNORE INTO TA (first_name,last_name, email, password, phone) VALUES ('$fname','$lname','$email','$password','$phone')";
        mysqli_query($db, $sql);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are logged in successfully!";
        header('location: scheduler.php');
        
    }

    //echo json_encode(array("status" => SUCCESS));



}

###########################################################################################################

function sqlNewAvailability(){
    $db = openDB();
    $stmt = $db->stmt_init();
    $stmt->prepare("INSERT INTO Available (email, section_id) VALUES (?, ?)");
    $stmt->bind_param("ss",$_POST["email"], $_POST["section_id"]);

    if (!$stmt->execute()) {
        echo json_encode(array("status" => SERVER_ERROR, "message" => "failed to add new availability"));
        return;
    }

    mysqli_close($db);

    echo json_encode(array("status" => SUCCESS));
}

###########################################################################################################

function sqlNewLogin(){
    $db = openDB();
    $stmt = $db->stmt_init();
    $stmt->prepare("INSERT OR IGNORE INTO Login (email, password) VALUES (?,?)");
    $stmt->bind_param("ss",$_POST["email"], $_POST["password"]);

    if (!$stmt->execute()) {
        echo json_encode(array("status" => SERVER_ERROR, "message" => "failed to add new login credentials"));
        return;
    }

    mysqli_close($db);

    echo json_encode(array("status" => SUCCESS));
}

###########################################################################################################

function sqlNewAbsense(){
    $db = openDB();
    $stmt = $db->stmt_init();
    $stmt->prepare("INSERT OR IGNORE INTO TAAbsence (f_name, l_name, email, section_id) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$_POST["f_name"], $_POST["l_name"], $_POST["email"], $_POST["section_id"]);

    if (!$stmt->execute()) {
        echo json_encode(array("status" => SERVER_ERROR, "message" => "failed to add new absense"));
        return;
    }

    mysqli_close($db);

    echo json_encode(array("status" => SUCCESS));
}

###########################################################################################################
*/

?>
