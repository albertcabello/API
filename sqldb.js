var mysql = require('mysql');

//Define the connection to the database, use a pool for performance reasons.
let con = mysql.createPool({
	connectionLimit: 1000,
	host: "127.0.0.1",
	user: "root",
	password: "corvette",
	database: "AppTestingUsers"
});

//Verify connection is working
con.getConnection( function(err) {
	if(err) {
		console.log(err);
	}
	else {
		console.log('Connected');
	}
});

//Query function to be used in other files, returns a promise with the results
exports.query = function(s) {
	var promise = new Promise((resolve, reject) => {
		con.query(s, function(err, response) {
			if (err) throw err;
			resolve(response);
		});
	});
	return promise;
}

