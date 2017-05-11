var sql = require('./sqldb');
const User = require('./User');
var express = require('express');
var graphqlHTTP = require('express-graphql');
var {buildSchema} = require('graphql');

//GraphQL schema
var schema = buildSchema(`
	input UserInput {
		username: String
		password: String
	}

	type User {
		updateCoordinates(latitude: Int, longitude: Int): Boolean
		print: String
	}

	type Query {
		createUser(username: String, password: String, email: String): Boolean
		login(username: String, password: String): User
	}
`);

//Resolvers function for each endpoint
var root = {

	login: function({username, password}) {
		var promise = User.login({username, password});
		return promise.then((exists) => {
			if (exists) {
				return new User(username, password);
			}
			return new User("Could not login", "Could not login");
		});
	},

	createUser: function({username, password, email}) {
		return User.createUser({username, password, email});
	},

};

//Set up the express server
var app = express();
app.use('/graphql', graphqlHTTP({ 
	schema: schema,
	rootValue: root,
	graphiql: true,
})),
app.listen(8000);
console.log('Run GraphQL API at localhost:8000/graphql');
