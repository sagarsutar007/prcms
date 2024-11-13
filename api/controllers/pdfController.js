const Exams = require("../models/examModel");

exports.generateOmr = (req, res) => {
    const { candidateId, examId } = req.query;

    Exams.findCandidateInExam(examId, candidateId, (err, records) => {
        if (err) {
            return res.status(500).json({ status: false, message: "Error checking exam records!" });
        }

        if (records.length === 0) {
			return res
				.status(400)
				.json({ status: false, message: "No exams found for this candidate!" });
        }

        return res.status(200).json({
            status: true,
            examId,
            candidateId,
            records,
        });
    });
}