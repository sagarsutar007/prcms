// controllers/examController.js
const Exams = require("../models/examModel");
const logApiRecord = require("../helpers/logHelper");
const { getClientType } = require("../helpers/clientHelper");
const { v4: uuidv4 } = require('uuid');
const db = require("../db/db");

exports.getCandidateExams = (req, res) => {
    const candidateId = req.id;

	// Fetch the candidate's exams
	Exams.findCandidateExams(candidateId, (err, results) => {
		if (err) {
			return res.status(500).json({ status: false, error: err.message });
		}

		if (results.length === 0) {
			return res
				.status(400)
				.json({ status: false, message: "No exams found for this candidate!" });
		}

		const userAgent = req.headers["user-agent"];
		const clientType = getClientType(userAgent);
		const ipAddress = req.ip;
		const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

		// Log the record
		logApiRecord(
			"candidate exams fetched",
			candidateId,
			ipAddress,
			macAddress,
			clientType
		)
			.then(() => {
				res.status(200).json({
					status: true,
					message: "Exams found successfully!",
					exams: results,
				});
			})
			.catch((logErr) => {
				res.status(500).json({ status: false, error: logErr.message });
			});
	});
};

exports.loadExam = (req, res) => {
    const { examUrl } = req.params;
    const candidateId = req.id;

    Exams.getExamByUrl(examUrl, (err, examInfo) => {
        if (err || !examInfo) {
            return res.status(400).json({ status: false, message: "Exam not found!" });
        }

        const exam = examInfo;
        const currentTime = new Date().getTime();
        const examStartTime = new Date(exam.exam_datetime).getTime();
        const remainingTime = Math.max((examStartTime - currentTime) / 1000, 0);
        
        Exams.findCandidateRecordsInExam(exam.id, candidateId, (err, candidateInfo) => {
            let leftAt = null;
            let examToken = null;
            if (err || !candidateInfo[0]) {
                leftAt = null;
                examToken = null;
            } else {
                leftAt = candidateInfo[0].left_at;
                examToken = candidateInfo[0].exam_token;
            }
            
            Exams.getExamQuestions(exam.id, (err, questions) => {
                if (err) {
                    return res.status(500).json({ status: false, message: "Error fetching questions!" });
                }

                const filteredQuestions = questions.map((question) => ({
                    question_id: question.question_id,
                    question_en: question.question_en,
                    question_hi: question.question_hi,
                    question_img: (question.question_img.length > 0) ? process.env.MAIN_URL + "assets/img/" + question.question_img : "",
                    question_type: question.question_type,
                }));

                let questionsWithAnswers = [];
                let processedQuestions = 0;

                Exams.getUserAnswersForExam(candidateId, exam.id, (err, userAnswers) => {
                    if (err) {
                        return res.status(500).json({ status: false, message: "Error fetching user answers!" });
                    }

                    const userAnswersMap = {};
                    userAnswers.forEach(answer => {
                        userAnswersMap[answer.question_id] = answer.answer_id;
                    });

                    filteredQuestions.forEach((question) => {
                        Exams.getAnswersByQuestionId(question.question_id, (err, answers) => {
                            if (err) {
                                return res.status(500).json({ status: false, message: "Error fetching answers!" });
                            }

                            questionsWithAnswers.push({
                                ...question,
                                answers: answers,
                                userAnswer: userAnswersMap[question.question_id] || null,
                            });

                            processedQuestions++;
                            if (processedQuestions === filteredQuestions.length) {
                                return res.status(200).json({
                                    status: true,
                                    examId: exam.id,
                                    examName: exam.name,
                                    examDuration: exam.duration,
                                    examLanguage: exam.lang,
                                    examQuestionsCount: questions.length,
                                    candidate: candidateId,
                                    examUrl: examUrl,
                                    remainingTime,
                                    examQuestions: questionsWithAnswers,
                                    examStartTime: exam.exam_datetime,
                                    examEndTime: exam.exam_endtime,
                                    leftAt,
                                    examToken
                                });
                            }
                        });
                    });
                });
            });
        });
    });
};

exports.submitCandidateAnswer = (req, res) => {
    const { examUrl } = req.params;
    const candidateId = req.id;
    const { questionId, answerId, examToken } = req.body;

    Exams.getExamByUrl(examUrl, (err, exam) => {
        if (err || !exam) {
            return res.status(400).json({ status: false, message: "Exam not found!" });
        }
        
        Exams.findCandidateRecordsInExam(exam.id, candidateId, (err, records) => {
            if (err) {
                return res.status(500).json({ status: false, message: "Error checking exam records!" });
            }
            
            if (!records || records[0].exam_token !== examToken) {
                return res.status(401).json({ status: false, message: "Invalid exam token!" });
            }
            
            Exams.getCorrectAnswer(questionId, (err, answer) => {
                if (err) {
                    return res.status(500).json({ status: false, message: "Error retrieving correct answer!" });
                }

                const answerStatus = (answer.id === answerId) ? 'correct' : 'incorrect';

                Exams.submitExamCandidateAnswer(candidateId, questionId, answerId, exam.id, answerStatus, (err, result) => {
                    if (err) {
                        return res.status(500).json({ status: false, message: "Error submitting answer!" });
                    }
                    return res.status(200).json({ status: true, message: "Answer stored successfully!" });
                });
            });
        });
    });
};


exports.getCandidateUpcomingExam = (req, res) => {
    const candidateId = req.id;

	Exams.findCandidateUpcomingExam(candidateId, (err, results) => {
		if (err) {
			return res.status(500).json({ status: false, error: err.message });
		}

		if (results.length === 0) {
			return res
				.status(400)
				.json({ status: false, message: "No exams found for this candidate!" });
		}

		const userAgent = req.headers["user-agent"];
		const clientType = getClientType(userAgent);
		const ipAddress = req.ip;
		const macAddress = req.headers["x-mac-address"] || "00:00:00:00:00:00";

		// Log the record
		logApiRecord(
			"candidate upcoming exam fetched",
			candidateId,
			ipAddress,
			macAddress,
			clientType
		)
			.then(() => {
				res.status(200).json({
					status: true,
					message: "Exams found successfully!",
					exam: results[0],
				});
			})
			.catch((logErr) => {
				res.status(500).json({ status: false, error: logErr.message });
			});
	});
};

exports.submitExamPaper = (req, res) => {
    const candidateId = req.id;  
    const { examId } = req.body; 
	const currentTime = new Date();
	currentTime.setHours(currentTime.getHours() + 5);
	currentTime.setMinutes(currentTime.getMinutes() + 30);
	
	const formattedTimeIST = currentTime.toISOString().slice(0, 19).replace('T', ' ');
	
    Exams.getExamById(examId, (err, examInfo) => {
        if (err || !examInfo) {
            return res.status(400).json({ status: false, message: "Exam not found!" });
		}
		
		const exam = examInfo;
		
        const sqlUpdate = `UPDATE candidate_exam_records 
                           SET left_at = ? 
                           WHERE user_id = ? AND exam_id = ?`;

        db.query(sqlUpdate, [formattedTimeIST, candidateId, examId], (updateErr, result) => {
            if (updateErr) {
                return res.status(500).json({ status: false, message: "Error updating exam record", error: updateErr });
			}
			
            if (result.affectedRows > 0) {
                return res.status(200).json({ status: true, message: "Exam submitted successfully" });
            } else {
                return res.status(400).json({ status: false, message: "Candidate record not found" });
            }
        });
    });
};

exports.startExamPaper = (req, res) => {
    const candidateId = req.id;
    const { examId } = req.body;
    const currentTime = new Date();
	currentTime.setHours(currentTime.getHours() + 5);
	currentTime.setMinutes(currentTime.getMinutes() + 30);
	
	const formattedTimeIST = currentTime.toISOString().slice(0, 19).replace('T', ' ');

    const sqlCheck = `SELECT * FROM candidate_exam_records WHERE user_id = ? AND exam_id = ?`;

    db.query(sqlCheck, [candidateId, examId], (checkErr, checkResult) => {
        if (checkErr) {
            return res.status(500).json({ status: false, message: "Error checking exam record", error: checkErr });
		}
		
		if (checkResult.length > 0) {
			if (checkResult[0].left_at !== "" && checkResult[0].re_entry === false) {
				return res.status(200).json({ status: false, message: "Candidate has already attempted this exam!" });
			}
            return res.status(200).json({ status: true, message: "Exam record already exists, no new entry required", authToken: checkResult[0].exam_token });
		}
		
		const authToken = uuidv4();
		
        const sqlInsert = `INSERT INTO candidate_exam_records (user_id, exam_id, entered_at, exam_token, re_entry)
                           VALUES (?, ?, ?, ?, ?)`;

        db.query(sqlInsert, [candidateId, examId, formattedTimeIST, authToken, "false"], (insertErr, result) => {
            if (insertErr) {
                return res.status(500).json({ status: false, message: "Error inserting exam record", error: insertErr });
            }

            return res.status(200).json({ status: true, message: "Exam start record inserted successfully", authToken: authToken });
        });
    });
};







