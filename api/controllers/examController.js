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

	// Fetch exam information by URL
	Exams.getExamByUrl(examUrl, (err, examInfo) => {
		if (err || !examInfo || examInfo.length === 0) {
			return res.status(400).json({ status: false, message: "Exam not found!" });
		}

		const exam = examInfo[0];

		// Get the current time and calculate the time left until the exam starts
		const currentTime = new Date().getTime();
		const examStartTime = new Date(exam.exam_datetime).getTime(); // Assuming `exam.start_time` is the start time
		const remainingTime = Math.max((examStartTime - currentTime) / 1000, 0); // Time left in seconds

		// Fetch questions for the exam
		Exams.getExamQuestions(exam.id, (err, questions) => {
			if (err) {
				return res.status(500).json({ status: false, message: "Error fetching questions!" });
			}

			// Filter questions to return only the required fields
			const filteredQuestions = questions.map((question) => ({
				question_id: question.question_id,
				question_en: question.question_en,
				question_hi: question.question_hi,
				question_img: (question.question_img.length > 0) ? process.env.MAIN_URL + "assets/img/" + question.question_img : "",
				question_type: question.question_type,
			}));

			// For each question, fetch the answers
			let questionsWithAnswers = [];
			let processedQuestions = 0;

			filteredQuestions.forEach((question) => {
				Exams.getAnswersByQuestionId(question.question_id, (err, answers) => {
					if (err) {
						return res.status(500).json({ status: false, message: "Error fetching answers!" });
					}

					// Add answers to the question object
					questionsWithAnswers.push({
						...question,
						answers: answers,
					});

					// Check if all questions have been processed
					processedQuestions++;
					if (processedQuestions === filteredQuestions.length) {

						// Send the response with remaining time
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
							
						});
					}
				});
			});
		});
	});
};



