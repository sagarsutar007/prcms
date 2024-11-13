const express = require("express");
const pdfController = require("../controllers/pdfController");
const authToken = require("../middleware/authenticateToken");
const router = express.Router();


router.get("/generate-omr", authToken, pdfController.generateOmr);

module.exports = router;