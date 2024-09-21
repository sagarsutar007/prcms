const Exams = require("../models/exams");

// Middleware to check if the question exists for the given exam
const checkQuestionExists = (req, res, next) => {
    const { examUrl } = req.params;
    const questionId = req.body.questionId;

    Exams.getExamByUrl(examUrl, (err, exam) => {
        if (err || !exam) {
            return res.status(400).json({ status: false, message: "Exam not found!" });
        }

        Exams.getExamQuestion(exam.id, questionId, (err, question) => {
            if (err || !question) {
                return res.status(400).json({ status: false, message: "Question not found!" });
            }
            req.question = question;
            next();
        });
    });
};

// Middleware to check if the candidate belongs to the exam
const checkCandidateBelongsToExam = (req, res, next) => {
    const { examUrl } = req.params;
    const candidateId = req.id;

    Exams.getExamByUrl(examUrl, (err, exam) => {
        if (err || !exam) {
            return res.status(400).json({ status: false, message: "Exam not found!" });
        }
        
        Exams.checkExamCandidateExists(candidateId, exam.id, (err, relationExists) => {
            if (err || !relationExists) {
                return res.status(403).json({ status: false, message: "Candidate does not belong to this exam!" });
            }
            next();
        });
    });
};

module.exports = {
    checkQuestionExists,
    checkCandidateBelongsToExam,
};
