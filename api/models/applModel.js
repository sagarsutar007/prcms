const db = require("../db/db");

const Appl = {
    getPrefs: (callback) => {
        const applQuery = "SELECT * FROM app_preferences WHERE id = ?";
        db.query(
            applQuery, [1], (err, results) => {
                if (err) {
                    return callback(err);
                }
                
                const record = results.length > 0 ? results[0] : null;
                callback(null, record);
            }
        );
    }
};

module.exports = Appl;
