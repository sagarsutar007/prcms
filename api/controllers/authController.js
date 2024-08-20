// controllers/authController.js
const md5 = require("md5");
const jwt = require("jsonwebtoken");
const useragent = require("useragent");
const User = require("../models/userModel");

const secretKey = process.env.SECRET_KEY;

const getClientType = (userAgent) => {
	const agent = useragent.parse(userAgent);
	if (agent.device.toString().toLowerCase().includes("mobile")) {
		return "phone";
	}
	return "computer";
};

exports.register = (req, res) => {
	const { name, email, phone, password } = req.body;
	const hashedPassword = md5(password);

	// Check if email already exists
	User.findByEmail(email, (err, emailResults) => {
		if (err) {
			return res.status(500).json({ status: false, error: err.message });
		}

		if (emailResults.length > 0) {
			return res
				.status(400)
				.json({ status: false, message: "Email already exists!" });
		}

		// Check if phone already exists
		User.findByPhone(phone, (err, phoneResults) => {
			if (err) {
				return res.status(500).json({ status: false, error: err.message });
			}

			if (phoneResults.length > 0) {
				return res
					.status(400)
					.json({ status: false, message: "Phone number already exists!" });
			}

			// If both email and phone are unique, proceed to register the user
			User.register(name, email, phone, hashedPassword, (err, results) => {
				if (err) {
					return res.status(500).json({ status: false, error: err.message });
				}

				const userId = results.id;

				const userAgent = req.headers["user-agent"];
				const clientType = getClientType(userAgent);
				const ipAddress = req.ip;
				const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

				// Log the registration
				logApiRecord(
					"candidate register",
					userId,
					ipAddress,
					macAddress,
					clientType
				)
					.then(() => {
						res.status(201).json({
							status: true,
							message: "User registered and logged successfully!",
							userId: userId,
						});
					})
					.catch((logErr) => {
						res.status(500).json({ status: false, error: logErr.message });
					});
			});
		});
	});
};

exports.personal = (req, res) => {
	const { highestQualification, gender, dob, userId } = req.body;

	// Find the user by ID
	User.find(userId, (err, userRec) => {
		if (err) {
			return res.status(500).json({ status: false, error: err.message });
		}

		if (userRec.length === 0) {
			return res
				.status(400)
				.json({ status: false, message: "User doesn't exist!" });
		}

		// Proceed to update the user's personal details
		User.updatePersonalDetails(
			userId,
			highestQualification,
			gender,
			dob,
			(err, results) => {
				if (err) {
					return res.status(500).json({ status: false, error: err.message });
				}

				const userAgent = req.headers["user-agent"];
				const clientType = getClientType(userAgent);
				const ipAddress = req.ip;
				const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

				// Log the update
				logApiRecord(
					"candidate personal details update",
					userId,
					ipAddress,
					macAddress,
					clientType
				)
					.then(() => {
						res.status(200).json({
							status: true,
							message:
								"User's personal details updated and logged successfully!",
							userId: userId,
						});
					})
					.catch((logErr) => {
						res.status(500).json({ status: false, error: logErr.message });
					});
			}
		);
	});
};

exports.organization = (req, res) => {
	const { companyId, employeeId, userId } = req.body;

	// Find the user by ID
	User.find(userId, (err, userRec) => {
		if (err) {
			return res.status(500).json({ status: false, error: err.message });
		}

		if (userRec.length === 0) {
			return res
				.status(400)
				.json({ status: false, message: "User doesn't exist!" });
		}

		// Proceed to update the user's personal details
		User.updateOrgDetails(userId, companyId, employeeId, (err, results) => {
			if (err) {
				return res.status(500).json({ status: false, error: err.message });
			}

			const userAgent = req.headers["user-agent"];
			const clientType = getClientType(userAgent);
			const ipAddress = req.ip;
			const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

			// Log the update
			logApiRecord(
				"candidate Organization details update",
				userId,
				ipAddress,
				macAddress,
				clientType
			)
				.then(() => {
					res.status(200).json({
						status: true,
						message: "User's company details updated and logged successfully!",
						userId: userId,
					});
				})
				.catch((logErr) => {
					res.status(500).json({ status: false, error: logErr.message });
				});
		});
	});
};

exports.login = (req, res) => {
	const { phone, password } = req.body;
	const hashedPassword = md5(password);
	const userAgent = req.headers["user-agent"];
	const clientType = getClientType(userAgent);
	const ipAddress = req.ip;
	const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

	User.findByPhone(phone, (err, results) => {
		if (err) {
			return res.status(500).json({ status: false, error: err.message });
		}

		if (results.length === 0) {
			return res
				.status(400)
				.json({ status: false, message: "Email not found!" });
		}

		const user = results[0];

		if (user.password !== hashedPassword) {
			return res
				.status(400)
				.json({ status: false, message: "Incorrect password!" });
		}

		const token = jwt.sign({ id: user.id, phone: user.phone }, secretKey, {
			expiresIn: "12h",
		});

		logApiRecord(
			"candidate login with password",
			user.id,
			ipAddress,
			macAddress,
			clientType
		)
			.then(() => res.json({ token }))
			.catch((logErr) =>
				res.status(500).json({ status: false, error: logErr.message })
			);
	});
};
