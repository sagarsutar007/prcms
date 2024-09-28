// controllers/examController.js
const Exams = require("../models/examModel");
const logApiRecord = require("../helpers/logHelper");
const { getClientType } = require("../helpers/clientHelper");

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

			filteredQuestions.forEach((question) => {
				Exams.getAnswersByQuestionId(question.question_id, (err, answers) => {
					if (err) {
						return res.status(500).json({ status: false, message: "Error fetching answers!" });
					}
					
					questionsWithAnswers.push({
						...question,
						answers: answers,
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
							examStartTime: exam.exam_datetime
						});
					}
				});
			});
		});
	});
};

exports.submitCandidateAnswer = (req, res) => {
    const { examUrl } = req.params;
    const candidateId = req.id;
    const questionId = req.body.questionId;
    const answerId = req.body.answerId;

    Exams.getExamByUrl(examUrl, (err, exam) => {
        if (err || !exam) {
            return res.status(400).json({ status: false, message: "Exam not found!" });
        }

        const question = req.question;  // Ensure that question is being set correctly

        if (question.question_type === "mcq") {
            Exams.getCorrectAnswer(questionId, (err, answer) => {
                if (err) {
                    return res.status(500).json({ status: false, message: "Error retrieving correct answer!" });
                }

                const answerStatus = (answer.id === answerId) ? 'correct' : 'incorrect';

                Exams.submitExamCandidateAnswer(candidateId, questionId, answerId, exam.id, answerStatus, (err, result) => {
                    if (err) {
                        return res.status(500).json({ status: false, message: "Error submitting answer!", error: err });
                    }
                    return res.status(200).json({ status: true, message: "Answer stored successfully!" });
                });
            });
        } else {
            // If question type is invalid, respond early
            return res.status(400).json({ status: false, message: "Invalid question type!" });
        }
    });
};





