const { submitAnswer } = require("../controllers/examController");
const db = require("../db/db");

const Exams = {
    findCandidateExams: (candidateId, callback) => {
        const query = `
            SELECT ex.* 
            FROM exams ex 
            INNER JOIN exam_candidates excd ON ex.id = excd.exam_id 
            WHERE excd.candidate_id = ?
            ORDER BY ex.exam_datetime DESC
        `;
        db.query(query, [candidateId], callback);
    },
    getExamByUrl: (examUrl, callback) => {
        const query = `SELECT * FROM exams WHERE url = ? LIMIT 1`;
        db.query(query, [examUrl], (err, results) => {
            if (err) return callback(err, null);
            return callback(null, results[0]);
        });
    },
    getExamQuestions: (examId, callback) => {
        const query = `SELECT * FROM questions q INNER JOIN exam_questions eq ON q.question_id = eq.question_id WHERE eq.exam_id = ? ORDER BY RAND()`;
        db.query(query, [examId], callback);
    },
    findCandidateInExam: (examId, candidateId, callback) => {
        const query = `
            SELECT * FROM exam_candidates 
            WHERE exam_id = ? AND candidate_id = ?`;
        db.query(query, [examId, candidateId], callback);
    },
    getAnswersByQuestionId: (questionId, callback) => {
        const query = `SELECT id, answer_text_en, answer_text_hi FROM answers WHERE question_id = ? ORDER BY RAND()`;
        db.query(query, [questionId], callback);
    },
    getQuestion: (questionId, callback) => {
        const query = `SELECT * FROM questions WHERE question_id = ? LIMIT 1`;
        db.query(query, [questionId], (err, results) => {
            if (err) return callback(err, null);
            return callback(null, results[0]);
        });
    },
    getExamQuestion: (examId, questionId, callback) => {
        const query = `SELECT q.* FROM exam_questions eq INNER JOIN questions q ON eq.question_id = q.question_id WHERE eq.exam_id = ? AND q.question_id = ? LIMIT 1`;
        db.query(query, [examId, questionId], (err, results) => {
            if (err) return callback(err, null);
            return callback(null, results[0]);
        });
    },
    getCorrectAnswer: (questionId, callback) => {
        const query = `SELECT * FROM answers WHERE question_id = ? AND isCorrect = 1 LIMIT 1`;
        db.query(query, [questionId], (err, results) => {
            if (err) return callback(err, null);
            return callback(null, results[0]);
        });
    },
    submitAnswer: (candidateId, questionId, answerId, examId, status, callback) => {
        const query = `INSERT INTO exam_records (user_id, question_id, answer_id, exam_id, status, created_at) VALUES (?, ?, ?, ?, ?, current_timestamp())`;
        
        db.query(query, [candidateId, questionId, answerId, examId, status], (err, results) => {
            if (err) return callback(err, null);
            return callback(null, results);
        });
    },
    checkExamCandidateExists: (candidateId, examId) => {
        const query = `SELECT * FROM exam_candidates WHERE candidate_id = ? AND exam_id = ?`;
        db.query(query, [candidateId, examId], (err, results) => {
            if (err) return callback(err, null);
            return callback(null, results[0]);
        });
    }

}

module.exports = Exams;