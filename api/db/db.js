const mysql = require("mysql2");

let connection;

function handleDisconnect() {
	connection = mysql.createConnection({
		host: "localhost",
		user: "root",
		password: "",
		database: "prcms",
	});

	connection.connect((err) => {
		if (err) {
			console.error("Error connecting to the database:", err.stack);
			setTimeout(handleDisconnect, 2000);
		} else {
			console.log("Connected to the database.");
		}
	});
	
	connection.on("error", (err) => {
		console.error("Database connection error:", err);
		if (err.code === "PROTOCOL_CONNECTION_LOST") {
			handleDisconnect();
		} else {
			throw err;
		}
	});
}

handleDisconnect();

module.exports = connection;
