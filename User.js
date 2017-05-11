var sql = require('./sqldb');

class User {

	constructor(username, password) {
		this.username = username;
		this.password = password;
	}

	//Add the user to the database and return the user
	static createUser({username, password, email}) {
		this.username = username;
		this.password = password;
		this.email = email;
		//SQL Query
		var s = `select * from users where username = '${this.username}'`;
		var result = sql.query(s);
		//A promise that when complete returns true or false based on success of adding the user to the database
		return result.then(response => {
			//The if statement checks if the username exists, if so don't add to the database
			if (response[0] && response[0].username) {
				console.log("Username taken");
				return false;
			}
			//Username doesn't exist, add them to the database
			else {
				s = `insert into users (username, password, email) 
					values ('${username}','${password}', '${email}')`;
				var result2 = sql.query(s);
				//To verify the user was added, attempt a login
				//Not sure if this works nor do I know how to fail a creation so RIP
//				return result2.then(response => {
//					return User.login({username: this.username, password: this.password});
//				});
				return true;
			}
		});
	}

	//Updates the coordinates for the current user
	updateCoordinates({latitude, longitude}) {
		//Update the latitude and longitude for the current user object, doesn't matter that it's done before the login check as Could not login is a 
		//fake username anyways
		this.latitude = latitude;
		this.longitude = longitude;
		//If the username/password is "Could not login", that means the supplied username and password are wrong
		//so just return false and don't modify the database and quit
		if (this.username == "Could not login") {
			return false;
		}
		else {
			//SQL Query 
			var s = `update users set latitude='${latitude}', longitude='${longitude}' where username='${this.username}'`;
			var result = sql.query(s);
			//Query has been performed, return true 
			return true;
		}
	}

	//Logs in the supplied username and password and returns a promise with true or false if it's a successful login
	//In server.js, if true, a new User object will be created with this username and password, if false a new User will be created
	//with username and password of "Could not login"
	static login({username, password}) {
		//SQL Query 
		var s = `select password from users where username='${username}'`;
		var result = sql.query(s);
		//A promise that is returned when complete, true if match in database
		return result.then(response => {
			//If statement checks if the username exists in the databse, then check if passwords match
			if (response[0] && response[0].password) {
				return (password == response[0].password);
			}
			//Username does not exist in database 
			return false;
		});
	}

}
module.exports = User;

