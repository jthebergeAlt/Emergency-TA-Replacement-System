const compression = require('compression');
const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');
const port = process.env.PORT || 8080;
const app = express();
const sqlite3 = require('sqlite3').verbose();

openDB();
/*
createTable();

insertNewTA("Ken", "Wakaba", "kwakaba@scu.edu", "253-227-5534");
insertNewTA("Ben","Wakaba","bwakaba@gmail.com","253-222-6678");
insertNewTA("Joe", "Smith", "jsmith@gmail.com", "123-456-7890");

insertNewAvailability("kwakaba@scu.edu", 123);
insertNewAvailability("kwakaba@scu.edu", 234);
insertNewAvailability("kwakaba@scu.edu", 456);

insertNewAvailability("bwakaba@gmail.com", 123);
insertNewAvailability("bwakaba@gmail.com", 456);
insertNewAvailability("bwakaba@gmail.com", 678);

insertNewAvailability("jsmith@gmail.com", 123);
insertNewAvailability("jsmith@gmail.com", 234);
insertNewAvailability("jsmith@gmail.com", 345);

insertLoginCredential("kwakaba@scu.edu", "1234");
insertLoginCredential("bwakaba@gmail.com", "abc");
insertLoginCredential("jsmith@gmail.com", "jsmith");

*/

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
				    first_name  TEXT NOT NULL,\
				    last_name   TEXT NOT NULL,\
				    email   	TEXT NOT NULL,\
				    phone   	TEXT NOT NULL\
		);");


		//Table that holds the listing of all the times the TA is available
		db.run("CREATE TABLE IF NOT EXISTS Available ( \
    				email   	TEXT NOT NULL, \
    				section_id 	INTEGER NOT NULL\
        );");


		db.run("CREATE TABLE IF NOT EXISTS Login( \
					email 		TEXT NOT NULL UNIQUE NOT NULL, \
					password 	TEXT NOT NULL \
		);");


		//Used to record the absences of TAs
		db.run("CREATE TABLE IF NOT EXISTS TAAbsence ( \
    				f_name			TEXT NOT NULL, \
    				l_name 			TEXT NOT NULL, \
    				email			TEXT NOT NULL, \
    				section_id		INTEGER NOT NULL \
		);");

	});
}


/*******************************************************************************/

//Verify the login information sent
function verifyLogin(email, password, callback) {
  
	db.serialize(function(){
		var p_word = [];
		var e_mail = [];

		db.each("SELECT email email, password password FROM Login", function(err, row) {
			p_word.push(row.password);
			e_mail.push(row.email);
		});

		if(p_word.includes(password) && e_mail.push(email)){
			return callback(true);
		} else{
			return callback(false);
		}
	});
}


/*******************************************************************************/

//Function that deletes all TA schedule and add in the new ones passed when saved is pressed
function saveSections(sections, email){

	db.serialize(function(){

		var remove = db.prepare("DELETE FROM Available WHERE email=?");
		remove.run(email); // Remove all the TAs old schedule

		for(section_id in sections){
			insertNewAvailability(email, section_id);
		}
		remove.finalize();
		
	});

}

/*******************************************************************************/

//Returns json that contains all the TAs in the system 
function getAllTAs(callback) {
	db.serialize(function(){
		var ta_array = [];
		db.each("SELECT first_name fname, last_name lname FROM TA", function(err, row) {
			var ta = row.fname + " " + row.lname;
			ta_array.push(ta);
        		
		});
		var json = '{ TAs : [ ' + ta_array.join() + '] }' ;
		var obj = JSON.parse(json);
		return callback(obj);	
	});
}

/*******************************************************************************/

//Returns json containing all the sections a TA is available for 
function getTASchedule(email, callback) {
	var section_array = [];
	db.serialize(function(){
		db.each("SELECT section_id section FROM Available", function(err, row) {
			section_array.push(section);
		});

		var json = '{ Sections : [ ' + section_array.join() + '] }' ;
		var obj = JSON.parse(json);
		return callback(obj);
	});
}

/*******************************************************************************/

function insertNewTA(fname, lname, email, phone) {
	db.serialize(function() {
		var ta = db.prepare("INSERT OR REPLACE INTO TA (first_name,last_name, email, phone) VALUES (?,?,?,?)");
		ta.run(fname, lname, email, phone);
		ta.finalize();

	});
}

/*******************************************************************************/

function insertNewAvailability(email, section_id) {
	db.serialize(function() {
		var avail = db.prepare("INSERT INTO Available (email, section_id) VALUES (?, ?)");
		avail.run(email, section_id);
		avail.finalize();

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

//Inserts a TA into the table that has all the recorded absences
function insertTAAbsence(f_name, l_name, email, section_id) {
	db.serialize(function() {

		db.serialize(function() {
		var absent = db.prepare("INSERT OR IGNORE INTO TAAbsence (f_name, l_name, email, section_id) VALUES (?,?,?,?)");

		c_avail.run(f_name, l_name, email, section_id);
		c_avail.finalize();
		});

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
