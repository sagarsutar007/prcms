// controllers/businessController.js
const User = require("../models/userModel");
const Business = require("../models/businessModel");
const logApiRecord = require("../helpers/logHelper");
const { getClientType } = require("../helpers/clientHelper");

exports.getBusinessUnits = (req, res) => {
	const userId = req.query.userId;

	User.findInfo(userId, (err, users) => {
		if (err) {
			return res.status(500).json({ status: false, error: err.message });
		}

		if (users.length === 0) {
			return res
				.status(400)
				.json({ status: false, message: "User not found!" });
		}
		// fetch units here
		Business.getAll((error, units) => {
			if (error) {
				return res
					.status(500)
					.json({ error: "An error occurred while fetching businesses." });
			}

			const userAgent = req.headers["user-agent"];
			const clientType = getClientType(userAgent);
			const ipAddress = req.ip;
			const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

			// Log the record
			logApiRecord(
				"Business units fetched!",
				userId,
				ipAddress,
				macAddress,
				clientType
			)
				.then(() => {
					res.status(200).json({
						status: true,
						message: "Business units found successfully!",
						units: units,
					});
				})
				.catch((logErr) => {
					res.status(500).json({ status: false, error: logErr.message });
				});
		});
	});
};
