const compression = require('compression');
const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');
const port = process.env.PORT || 8080;
const app = express();
const sqlite3 = require('sqlite3').verbose();

openDB();

app.use(compression());
app.use(express.static(__dirname + '/src'));
app.use(express.static(__dirname + '/node_modules'));

// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }))

// parse application/json
app.use(bodyParser.json())

app.get('*', (req, res) => {
  res.sendFile(path.resolve(__dirname, 'src/login.html'))
});

app.post('/auth', function (req, res) {
  verifyLogin(req.body.email, req.body.password, function(verified){
    if(verified)
      res.sendFile(path.resolve(__dirname, 'src/scheduling.html'));
    else
      res.sendFile(path.resolve(__dirname, 'src/loginFailed.html'));
  })

});

app.post('/create', function (req, res) {
  res.json({test: 'testing'});
});

app.post('/update', function (req, res) {
  res.json({test: 'testing'});
});

app.listen(port);
console.info("Server started on port " + port);





/******************************************************************************
DATABASE
******************************************************************************/

var db;

function openDB() {
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
			return console.error(err.message);
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
    				section_name 	TEXT NOT NULL, \
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


		//Used to check for valid course names
		db.run("CREATE TABLE IF NOT EXISTS CoursesAvailable ( \
    				course_name    TEXT NOT NULL UNIQUE NOT NULL, \
    				section_id		INTEGER PRIMARY KEY, \
    				ta_id			INTEGER NOT NULL, \
    				ta_f_name		TEXT NOT NULL ,\
    				ta_l_name		TEXT NOT NULL\
		);");

		//Used to record the absences of TAs
		db.run("CREATE TABLE IF NOT EXISTS TAAbsence ( \
    				ta_id    		INTEGER NOT NULL, \
    				ta_name			TEXT NOT NULL, \
    				course_name		TEXT NOT NULL, \
    				section_id		INTEGER PRIMARY KEY \
		);");



	});
}


/*******************************************************************************/

//Verify the login information sent
function verifyLogin(email, password, callback) {
  var verified = false;
	db.serialize(function(){
		db.each("SELECT email email, password password FROM Login", function(err, row) {
      if(row.email == email && row.password == password)
        return callback(true);
		});
	});
}

/*******************************************************************************/

function insertNewTA(fname, lname, id, email, phone) {
	db.serialize(function() {
		var ta = db.prepare("INSERT OR REPLACE INTO TA (first_name,last_name, id, email, phone) VALUES (?,?,?,?,?)");
		ta.run(fname, lname, id, email, phone);
		ta.finalize();

	});
}

/*******************************************************************************/

function insertNewAvailability(id, start, end) {
	db.serialize(function() {
		var avail = db.prepare("INSERT INTO Available (ta_id, start_t, end_t) VALUES (?, ? , ?)");
		avail.run(id, start, end);
		avail.finalize();

	});
}

/*******************************************************************************/

function insertNewCourse(course) {
	db.serialize(function() {
		var courses = db.prepare("INSERT OR REPLACE INTO Courses (name) VALUES (?)");
		courses.run(course);
		courses.finalize();

	});
}

/*******************************************************************************/

function insertNewTAClass(id, course) {
	db.serialize(function() {
		var ta_class = db.prepare("INSERT INTO TAClasses (ta_id, course_name) VALUES(?,?)");
		ta_class.run(id, course);
		ta_class.finalize();

	});
}

/*******************************************************************************/

function insertNewSectionTime(id, name, start, end) {
	db.serialize(function() {
		var section = db.prepare("INSERT OR REPLACE INTO SectionTimes (id, name, start_t, end_t) VALUES (?,?,?,?)");

		section.run(id, name, start, end);
		section.finalize();

	});
}

/*******************************************************************************/

function insertLoginCredential(email, password) {
	db.serialize(function() {
		var login = db.prepare("INSERT OR IGNORE INTO Login (email, password) VALUES (?,?)");

		login.run(email, password);
		login.finalize();

	});
}


/*******************************************************************************/

//Inserts the TAs that are available for certain sections
function insertAvailableCourses(course_name, section_id, ta_id, ta_f_name, ta_l_name) {
	db.serialize(function() {
		var c_avail = db.prepare("INSERT OR IGNORE INTO CoursesAvailable (course_name, section_id, ta_id, ta_f_name, ta_l_name) VALUES (?,?,?,?,?)");

		c_avail.run(course_name, section_id, ta_id, ta_f_name, ta_l_name);
		c_avail.finalize();

	});
}

/*******************************************************************************/

//Retrieves all TAs that are available for a certain lab section
function retrieveAvailableTA(section_id) {
	db.serialize(function() {
		var available = [];
		db.each("SELECT ta_f_name fname, ta_l_name lname FROM CoursesAvailable WHERE section_id = ?" , section_id, function(err, row){
			var name = row.fname + " " + row.lname;
			available.push(name);
		});

		var json = '{ "sections" : [ ' + available.join() + '] }' ;
		var obj = JSON.parse(json);
		return obj;
	});
}

/*******************************************************************************/

//Inserts a TA into the table that has all the recorded absences
function addTAAbsence(ta_id, ta_name, course_name, section_id) {
	db.serialize(function() {

		db.serialize(function() {
		var absent = db.prepare("INSERT OR IGNORE INTO TAAbsence (ta_id, ta_name, course_name, section_id) VALUES (?,?,?,?)");

		c_avail.run(ta_id, ta_name, course_name, section_id);
		c_avail.finalize();
		});

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
