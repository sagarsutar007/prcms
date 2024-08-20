const db = require("../db/db");

const logApiRecord = (type, userId, ipAddress, macAddress, client) => {
	const log = {
		type,
		user_id: userId,
		datetime: new Date(),
		ip_address: ipAddress,
		mac_address: macAddress,
		client,
	};

	return new Promise((resolve, reject) => {
		db.query("INSERT INTO api_logs_tbl SET ?", log, (err, results) => {
			if (err) {
				return reject(err);
			}
			resolve(results);
		});
	});
};

module.exports = logApiRecord;
