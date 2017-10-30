var sqlite3 = require('sqlite3').verbose();
var db;

function openDB(sqlite3) {
	db = new sqlite3.Database('mydb.db', (err) => {
		if (err) {
	    	return console.error(err.message);
	  	}
	  	console.log('Connected to the my SQlite database.');
	});
}

/*******************************************************************************/

function closeDB() {
	db.close((err) => {
		if (err) {
			return console.error(err.message);
		}
	console.log('Close the database connection.');
	});
}

/*******************************************************************************/

function createTable() {
	db.serialize(function() {

		//Table that holds all the contact information about the TA
		db.run("CREATE TABLE IF NOT EXISTS TA (\
				    first_name   TEXT NOT NULL,\
				    last_name   TEXT NOT NULL,\
				    id      INTEGER PRIMARY KEY,\
				    email   TEXT NOT NULL,\
				    phone   TEXT NOT NULL\
		);");


		//Table that holds the listing of all the times the TA is available
		db.run("CREATE TABLE IF NOT EXISTS Available ( \
    				ta_id   INTEGER NOT NULL, \
    				start_t TIME NOT NULL, \
    				end_t   TIME NOT NULL, \
    				FOREIGN KEY (ta_id) \
        				REFERENCES TA(id) \
        				ON DELETE CASCADE\
        );");

		//Table holding the classes in which the TA can teach 
		db.run("CREATE TABLE IF NOT EXISTS TAClasses ( \
    				ta_id       INTEGER, \
				    course_name TEXT NOT NULL, \
				    FOREIGN KEY (ta_id) \
				        REFERENCES TA(id) \
				        ON DELETE CASCADE, \
				    FOREIGN KEY (course_name) \
				        REFERENCES Courses(name) \
				        ON DELETE CASCADE \
		);");

		//Table consisting of the lab section times 
		db.run("CREATE TABLE IF NOT EXISTS SectionTimes ( \
				    id      INTEGER PRIMARY KEY, \
				    name    TEXT NOT NULL, \
				    start_t TIME, \
				    end_t   TIME, \
				    FOREIGN KEY (name) \
				        REFERENCES Courses(name) \
				        ON DELETE CASCADE \
		);");

		db.run("CREATE TABLE IF NOT EXISTS Login( \
					email TEXT NOT NULL UNIQUE NOT NULL, \
					password TEXT NOT NULL \
		);");

		//Used to check for valid course names
		db.run("CREATE TABLE IF NOT EXISTS Courses ( \
    				name    TEXT NOT NULL UNIQUE NOT NULL \
		);");

	});
}

/*******************************************************************************/

function insertIntoTable() {
	db.serialize(function() {
		
		var ta = db.prepare("INSERT OR REPLACE INTO TA (first_name,last_name, id, email, phone) VALUES (?,?,?,?,?)");
		var avail = db.prepare("INSERT INTO Available (ta_id, start_t, end_t) VALUES (?, ? , ?)");
		var ta_class = db.prepare("INSERT INTO TAClasses (ta_id, course_name) VALUES(?,?)");
		var courses = db.prepare("INSERT OR REPLACE INTO Courses (name) VALUES (?)");
		
		var login = db.prepare("INSERT OR IGNORE INTO Login (email, password) VALUES (?,?)");

		login.run("kwwakaba@gmail.com", "1234");
		login.run("kwakaba@scu.edu", "4321");
		login.run("kwwakaba@yahoo.com", "123");

		/*
		ta.run("Bob", "Jones", 0 ,"bjones@scu.edu", "111-111-1111");
		ta.run("Bill", "Ding", 1 , "bding@scu.edu", "222-222-2222");
		
		avail.run(0, "9:15", "12:00");
		avail.run(0, "17:00", "20:30");
		avail.run(1, "14:15", "17:00");
		avail.run(1, "17:15", "20:00");


		ta_class.run(0, "COEN 100");
		ta_class.run(1, "COEN 100");
		ta_class.run(1, "COEN 200");


		courses.run("COEN 100");
		courses.run("COEN 200");
		*/
		ta.finalize();
		avail.finalize();
		ta_class.finalize();
		courses.finalize();
		login.finalize();

		
		/*
		db.each("SELECT id id, first_name name, email email FROM TA", function(err, row) {
			console.log(row.id + ": " + row.name + ": " + row.email);
		});
		*/


	});

}

/*******************************************************************************/

function deleteFromTable() {
	db.serialize(function() {
		var stmt = db.prepare("DELETE FROM TA WHERE rowid=?");
		stmt.run(3);

		stmt.finalize();

		db.each("SELECT id id, first_name name FROM TA", function(err, row) {
			console.log(row.id + ": " + row.name);
		});
	});
}

/*******************************************************************************/

function verifyLogin(email, password){
	var check = false;

	db.serialize(function(){
		//check = true;
		db.each("SELECT email email, password password FROM Login", function(err, row) {
			if(row.email == email && row.password == password){
				check = true;
				return check;
				console.log(check);
				console.log("found user");
			} 
		});

	});

}


/*******************************************************************************/



openDB(sqlite3);

createTable();
insertIntoTable();
verifyLogin("kwwakaba@gmail.com", 1234);
//verifyLogin("kwakaba@scu.edu", 4321);

//deleteFromTable();

closeDB(sqlite3);

