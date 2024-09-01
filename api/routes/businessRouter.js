// routes/businessRouter.js
const express = require("express");
const businessController = require("../controllers/businessController");
const router = express.Router();

// Business Units
router.get("/get-business-units", businessController.getBusinessUnits);

module.exports = router;
