# Icebreaker-API
PHP API for the Icebreaker App

Hello everyone!  This is my API for the Icebreaker App.  As of now, when you go to local host with HTTP parameters of userGiven and passGiven, which are the username and password respectively, the API will check if your username and password exist on the MySQL database and if they match.  If they do, the index.php file goes through the different methods specified.  The methods of the API work all I need to figure out now is how to make them work with the main Icebreaker app.  Wish me luck!


# How to use this API
To use this when demoing the Icebreaker app, make sure you have mySQL installed on your computer.  In mySQL, have a database called AppTestingUsers, in it, have two tables, one called preferences, one called users.  In users, have five columns, username of type VARCHAR(100), password of type VARCHAR(100), email of type VARCHAR(100), latitude of type DECIMAL(16,14), and longitude of type DECIMAL(16, 14).  Now run index.php on an apache local server, and then the app should work!









