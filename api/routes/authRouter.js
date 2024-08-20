// routes/authRouter.js
const express = require("express");
const authController = require("../controllers/authController");
const router = express.Router();

// User registration
router.post("/register", authController.register);

// User login
router.post("/login", authController.login);

module.exports = router;
