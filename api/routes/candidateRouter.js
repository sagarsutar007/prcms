// routes/authRouter.js
const express = require("express");
const candidateController = require("../controllers/candidateController");
const router = express.Router();

router.get("/get-candidate-details", candidateController.getCandidateDetails);

module.exports = router;
