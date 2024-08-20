const db = require("../db/db");

const User = {
	register: (name, email, password, callback) => {
		const query =
			"INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?)";
		db.query(query, [name, email, phone, password], callback);
	},

	findByEmail: (email, callback) => {
		const query = "SELECT * FROM candidates WHERE email = ?";
		db.query(query, [email], callback);
	},

	findByPhone: (phone, callback) => {
		const query = "SELECT * FROM candidates WHERE phone = ?";
		db.query(query, [phone], callback);
	},

	updatePersonalDetails: (
		userId,
		highestQualification,
		gender,
		dob,
		callback
	) => {
		const candidateDetailsQuery =
			"UPDATE candidate_details SET highest_qualification = ?, gender = ?, dob = ? WHERE user_id = ?";

		const candidateQuery = "UPDATE candidates SET gender = ? WHERE id = ?";

		db.query(
			candidateDetailsQuery,
			[highestQualification, gender, dob, userId],
			(err, results) => {
				if (err) {
					return callback(err);
				}

				db.query(candidateQuery, [gender, userId], (err, results) => {
					if (err) {
						return callback(err);
					}

					callback(null, results);
				});
			}
		);
	},
	updateOrgDetails: (userId, companyId, employeeId, callback) => {
		const candidateDetailsQuery =
			"UPDATE candidate_details SET company_id = ? WHERE user_id = ?";

		const candidateQuery = "UPDATE candidates SET company_id = ? WHERE id = ?";

		db.query(candidateDetailsQuery, [companyId, userId], (err, results) => {
			if (err) {
				return callback(err);
			}

			db.query(candidateQuery, [employeeId, userId], (err, results) => {
				if (err) {
					return callback(err);
				}

				callback(null, results);
			});
		});
	},
	find: (userId, callback) => {
		const query = "SELECT * FROM users WHERE id = ?";
		db.query(query, [userId], callback);
	},
};

module.exports = User;
