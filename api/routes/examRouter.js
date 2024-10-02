const express = require("express");
const examController = require("../controllers/examController");
const authToken = require("../middleware/authenticateToken");
const { checkQuestionExists, checkCandidateBelongsToExam } = require("../middleware/examMiddleware");
const router = express.Router();

router.get("/candidate-exams", authToken, examController.getCandidateExams);
router.get("/candidate-exam", authToken, examController.getCandidateUpcomingExam);
router.post("/submit-paper", authToken, examController.submitExamPaper);
router.post("/start-paper", authToken, examController.startExamPaper);
router.get("/load-exam-questions/:examUrl", authToken, examController.loadExam);
router.post("/submit-answer/:examUrl", authToken, checkQuestionExists, checkCandidateBelongsToExam, examController.submitCandidateAnswer);

module.exports = router;
