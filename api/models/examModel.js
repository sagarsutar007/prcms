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
        const query = `SELECT * FROM exams WHERE url = ?`;
        db.query(query, [examUrl], callback);
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
    }
}

module.exports = Exams;