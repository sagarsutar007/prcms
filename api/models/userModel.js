const db = require("../db/db");

const User = {
	register: (
		firstname,
		middlename,
		lastname,
		email,
		phone,
		password,
		callback
	) => {
		const query =
			"INSERT INTO candidates (firstname, middlename, lastname, email, phone, password, source, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		db.query(
			query,
			[
				firstname,
				middlename,
				lastname,
				email,
				phone,
				password,
				"manual",
				"active",
			],
			callback
		);
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
	findInfo: (userId, callback) => {
		const query =
			"SELECT CONCAT_WS(' ', firstname, middlename, lastname) AS fullName, cd.user_id as userId, empid as employeeId, gender, phone, email, profile_img, dob, highest_qualification, education_proof, passout_year, percentage_secured, aadhaar_number, aadhaar_card_front_pic, aadhaar_card_back_pic, pancard_pic, voter_id, pa_address, pa_address_landmark, pa_city, pa_dist, pa_pin, pa_state, ca_address, ca_address_landmark, ca_city, ca_dist, ca_pin, ca_state, whatsapp_number, father_name, bank_name, account_num, ifsc_code, marital_status, passbook_pic, chequebook_pic, status, c.company_id AS companyId, source, created_at, edited_at, logged_in_at as lastLoggedIn FROM candidates c LEFT JOIN candidate_details cd ON c.id = cd.user_id WHERE c.id = ?";
		db.query(query, [userId], callback);
	},
};

module.exports = User;
