var sql = require('./sqldb');
var express = require('express');
var graphqlHTTP = require('express-graphql');
var {buildSchema} = require('graphql');

//GraphQL schema
var schema = buildSchema(`
	input UserInput {
		username: String
		password: String
	}

	type Mutation {
		createUser(username: String, password: String, email: String, latitude: Int, longitude: Int): Boolean
		updateCoordinates(username: String, password: String, latitude: Int, longitude: Int): Boolean
	}

	type Query {
		login(username: String, password: String): Boolean
	}
`);

//Resolvers function for each endpoint
var root = {

	login: login,

	createUser: function({username, password, email, latitude, longitude}) {
		//SQL Query
		var s = `select * from users where username = '${username}'`;
		var result = sql.query(s);
		//A promise that when complete returns true or false based on success of adding the user to the database
		return result.then(response => {
			//The if statement checks if the username exists, if so don't add to the database
			if (response[0] && response[0].username) {
				return false;
			}
			//Username doesn't exist, add them to the database
			else {
				s = `insert into users (username, password, email, latitude, longitude) 
					values ('${username}','${password}', '${email}', '${latitude}', '${longitude}')`;
				result2 = sql.query(s);
				//To verify the user was added, attempt a login
				//Not sure if this works nor do I know how to fail a creation so RIP
				return result2.then(response => {
					return login({username, password});
				});
			}
		});
	},

	updateCoordinates({username, password, latitude, longitude}) {
		//Check if the username and password are fine 
		var loggedIn = login({username, password});
		//If the username and password match database, perform update
		return loggedIn.then((match) => {
			//If match is false, then the username and password didnt match 
			if (!match) {
				return false;
			}
			//Username and password must match database so perform the query 
			var s = `update users set latitude=${latitude}, longitude=${longitude} where username='${username}'`;
			var result = sql.query(s);
			//If username and password worked, we should be able to perform the query with no issue so return true
			return true;
		});
	},
};

//Returns a boolean if the given username and password matches the database
function login({username, password}) {
	//SQL Query 
	var s = `select password from users where username='${username}'`;
	var result = sql.query(s);
	//A promise that is returned when complete, true if match in database
	return result.then(response => {
		//If statement checks if the username exists in the databse, then check if passwords match
		if (response[0] && response[0].password) {
			return password == response[0].password;
		}
		//Username does not exist in database 
		return false;
	});
}

//Set up the express server
var app = express();
app.use('/graphql', graphqlHTTP({ 
	schema: schema,
	rootValue: root,
	graphiql: true,
})),
app.listen(8000);
console.log('Run GraphQL API at localhost:8000/graphql');
