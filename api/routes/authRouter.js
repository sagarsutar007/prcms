// routes/authRouter.js
const express = require("express");
const authController = require("../controllers/authController");
const {
	isValidRegistration,
	isValidLogin,
} = require("../middleware/validationMiddleware");
const router = express.Router();

// User registration
router.post("/register", isValidRegistration, authController.register);
router.post("/update-personal-info", authController.personal);
router.post("/update-organisation-info", authController.organization);

// User login
router.post("/login", isValidLogin, authController.login);

module.exports = router;
