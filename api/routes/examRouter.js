const express = require("express");
const examController = require("../controllers/examController");
const authToken = require("../middleware/authenticateToken");
const router = express.Router();

router.get("/candidate-exams", authToken, examController.getCandidateExams);
router.get("/load-exam-questions/:examUrl", authToken, examController.loadExam);

module.exports = router;
