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


function connectToDatabase()
{
    $database = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Error" . mysqli_error($database));
    return $database;
}



function verifyLogin($username, $password)
{
    # connect to the database
    $db = connectToDatabase();
    $stmt = $db->stmt_init();

    # getting the query ready
    $query = "SELECT password FROM Login WHERE username = ?";

    $stmt->prepare($query);
    $stmt->bind_param("s", $username);

    # verify login information 
    if ($stmt->execute()) {
        $stmt->bind_result($result);
        if ($stmt->fetch() && password_verify($password, $result)) {
            # valid credentials
            return SUCCESS;
        }
        # invalid credentials
        return INVALID_LOGIN;
    }
    # query failed to execute
    return SERVER_ERROR;
}