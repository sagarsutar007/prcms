// controllers/candidateController.js
const User = require("../models/userModel");
const logApiRecord = require("../helpers/logHelper");
const { getClientType } = require("../helpers/clientHelper");

exports.getCandidateDetails = (req, res) => {
	const userId = req.query.userId;

	User.findInfo(userId, (err, results) => {
		const user = results[0];

		if (err) {
			return res.status(500).json({ status: false, error: err.message });
		}

		if (results.length === 0) {
			return res
				.status(400)
				.json({ status: false, message: "User not found!" });
		}
		const userAgent = req.headers["user-agent"];
		const clientType = getClientType(userAgent);
		const ipAddress = req.ip;
		const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

		// Log the record
		logApiRecord(
			"candidate personal details fetched",
			userId,
			ipAddress,
			macAddress,
			clientType
		)
			.then(() => {
				res.status(200).json({
					status: true,
					message: "User found successfully!",
					userdata: user,
				});
			})
			.catch((logErr) => {
				res.status(500).json({ status: false, error: logErr.message });
			});
	});
};
