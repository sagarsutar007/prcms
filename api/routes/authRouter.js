const express = require("express");
const md5 = require("md5");
const jwt = require("jsonwebtoken");
const useragent = require("useragent");
const db = require("../db/db");
const router = express.Router();

const secretKey = "ERohPNcyfDQlKRAR4ZD6vi0p0BigIM73";

const getClientType = (userAgent) => {
	const agent = useragent.parse(userAgent);
	if (agent.device.toString().toLowerCase().includes("mobile")) {
		return "phone";
	}
	return "computer";
};

// User registration
router.post("/register", (req, res) => {
	const { name, email, password } = req.body;
	const hashedPassword = md5(password);

	db.query(
		"INSERT INTO users (name, email, password) VALUES (?, ?, ?)",
		[name, email, hashedPassword],
		(err, results) => {
			if (err) {
				return res.status(500).json({ error: err.message });
			}
			res.status(201).json({ message: "User registered successfully!" });
		}
	);
});

// User login
router.post("/login", (req, res) => {
	const { email, password } = req.body;
	const hashedPassword = md5(password);

	const userAgent = req.headers["user-agent"];
	const clientType = getClientType(userAgent);
	const ipAddress = req.ip;
	const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

	// First check if the email exists
	db.query(
		"SELECT * FROM candidates WHERE email = ?",
		[email],
		(err, results) => {
			if (err) {
				return res.status(500).json({ error: err.message });
			}

			if (results.length === 0) {
				return res.status(400).json({ message: "Email not found!" });
			}

			const user = results[0];

			// Then check if the password is correct
			if (user.password !== hashedPassword) {
				return res.status(400).json({ message: "Incorrect password!" });
			}

			const token = jwt.sign({ id: user.id, email: user.email }, secretKey, {
				expiresIn: "12h",
			});

			// Store log in database
			const log = {
				type: "candidate",
				user_id: user.id,
				datetime: new Date(),
				ip_address: ipAddress,
				mac_address: macAddress,
				client: clientType,
			};

			db.query("INSERT INTO logs_tbl SET ?", log, (logErr, logResults) => {
				if (logErr) {
					return res.status(500).json({ error: logErr.message });
				}
				res.json({ token });
			});
		}
	);
});

module.exports = router;
