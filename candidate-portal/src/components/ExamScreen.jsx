import { useParams } from "react-router-dom";
import { Helmet, HelmetProvider } from "react-helmet-async";
import { useEffect, useState } from "react";
import axios from "axios";
import ExamNavbar from "./ExamAssets/ExamNavbar";
import ExamSidebar from "./ExamAssets/ExamSidebar";
import ExamFooter from "./ExamAssets/ExamFooter";
import ExamQuestion from "./ExamAssets/ExamQuestion";
import ExamDetail from "./ExamAssets/ExamDetail";

// Redux imports
import { useDispatch } from "react-redux";
import { setQuestions } from "../features/exam/examSlice";
import ExamLoading from "./ExamAssets/ExamLoading";

const ExamScreen = () => {
	const { examUrl } = useParams();
	const [examData, setExamData] = useState(null);
	const [timeLeft, setTimeLeft] = useState(null);
	const [examStarted, setExamStarted] = useState(false);
	const [loading, setLoading] = useState(true);
	const [countdown, setCountdown] = useState(5);

	const dispatch = useDispatch();

	useEffect(() => {
		const fetchData = async () => {
			try {
				const response = await axios.get(
					process.env.SERVER_API_URL + "load-exam-questions/" + examUrl,
					{
						headers: {
							"x-auth-token": localStorage.getItem("token"),
						},
					}
				);
				const examData = response.data;
				setExamData(examData);
				dispatch(setQuestions(examData.examQuestions));
				if (examData.remainingTime > 0) {
					setTimeLeft(examData.remainingTime);
					setLoading(false);
				} else {
					setExamStarted(true);
				}
				setLoading(false);
			} catch (error) {
				console.error("Error fetching data", error);
			}
		};

		fetchData();
	}, [examUrl, dispatch]);

	useEffect(() => {
		if (countdown > 0) {
			const timer = setInterval(() => {
				setCountdown((prevCount) => {
					if (prevCount <= 1) {
						clearInterval(timer);
						setExamStarted(true);
						return 0;
					}
					return prevCount - 1;
				});
			}, 1000);

			return () => clearInterval(timer);
		}
	}, [countdown]);

	return (
		<HelmetProvider>
			<Helmet>
				<title>{examData ? `${examData.examName}` : "Loading Exam..."}</title>
			</Helmet>
			<div className="wrapper">
				{loading && <ExamLoading />}
				{!loading && !examStarted && (
					<ExamDetail examData={examData} countdown={countdown} />
				)}
				{!loading && examStarted && (
					<>
						<ExamNavbar
							examTitle={examData ? examData.examName : "Not Available"}
							remainingTime={timeLeft}
						/>
						<ExamSidebar />
						<ExamQuestion />
						<ExamFooter />
					</>
				)}
			</div>
		</HelmetProvider>
	);
};

export default ExamScreen;
