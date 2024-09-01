const db = require("../db/db");

const Business = {
	getAll: (callback) => {
		const query = `
            SELECT DISTINCT c.id AS id, 
                            c.company_name, 
                            c.company_logo, 
                            c.company_about, 
                            c.company_address 
            FROM companies c
            JOIN com_usr_link cul ON c.id = cul.company_id
            JOIN business_units bu ON bu.id = cul.user_id
            WHERE cul.type = ?`;

		// Execute the query with the parameter for the WHERE clause
		db.query(query, ["business unit"], (error, results) => {
			if (error) {
				return callback(error);
			}
			callback(null, results);
		});
	},
};

module.exports = Business;
