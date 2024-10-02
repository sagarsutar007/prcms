const jwt = require("jsonwebtoken");
const secretKey = process.env.SECRET_KEY;
require("dotenv").config();

const authToken = async (req, res, next) => {
	const token = req.header("x-auth-token");

	// If token not found, send error message
	if (!token) {
		res.status(401).json({
			errors: [
				{
					msg: "Token not found",
				},
			],
		});
	}

	// Authenticate token
	try {
		const user = await jwt.verify(token, secretKey);
		req.user = user.email;
		req.id = user.id;
		req.token = token;
		next();
	} catch (error) {
		res.status(403).json({
			errors: [
				{
					msg: "Invalid token",
				},
			],
		});
	}
};

module.exports = authToken;
