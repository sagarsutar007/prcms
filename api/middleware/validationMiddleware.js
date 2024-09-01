const { body, validationResult } = require("express-validator");

const isValidRegistration = [
	body("name").notEmpty().withMessage("Name is required"),
	body("email").isEmail().normalizeEmail().withMessage("Invalid email format"),
	body("phone").isMobilePhone().withMessage("Invalid phone number format"),
	body("password")
		.isLength({ min: 6 })
		.withMessage("Password must be at least 6 characters long"),
	(req, res, next) => {
		const errors = validationResult(req);
		if (!errors.isEmpty()) {
			return res.status(400).json({ errors: errors.array() });
		}
		next();
	},
];

const isValidLogin = [
	body("phone").notEmpty().withMessage("Invalid phone number"),
	body("password").notEmpty().withMessage("Password is required"),
	(req, res, next) => {
		const errors = validationResult(req);
		if (!errors.isEmpty()) {
			return res.status(400).json({ errors: errors.array() });
		}
		next();
	},
];

module.exports = { isValidRegistration, isValidLogin };
