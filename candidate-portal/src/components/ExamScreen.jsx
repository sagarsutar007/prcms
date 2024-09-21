import { useParams } from "react-router-dom";
import { Helmet, HelmetProvider } from "react-helmet-async";
import { useEffect, useState } from "react";
import axios from "axios";
import ExamNavbar from "./ExamAssets/ExamNavbar";
import ExamSidebar from "./ExamAssets/ExamSidebar";
import ExamFooter from "./ExamAssets/ExamFooter";
import ExamQuestion from "./ExamAssets/ExamQuestion";

// Redux imports
import { useDispatch } from 'react-redux';
import { setQuestions } from '../features/exam/examSlice';
import ExamLoading from "./ExamAssets/ExamLoading";

const ExamScreen = () => {
    const { examUrl } = useParams();
    const [examData, setExamData] = useState(null);  // Initialize with null to check loading state
    const [timeLeft, setTimeLeft] = useState(null);
    const [examStarted, setExamStarted] = useState(false);
    const [loading, setLoading] = useState(true);  // Initial state for spinner
    const [countdown, setCountdown] = useState(50);

    const dispatch = useDispatch();

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(process.env.SERVER_API_URL + "load-exam-questions/" + examUrl, {
                    headers: {
                        "x-auth-token": localStorage.getItem("token"),
                    },
                });
                const examData = response.data;
                setExamData(examData);  // Set exam data when received

                dispatch(setQuestions(examData.examQuestions));  // Store the questions in Redux

                if (examData.timeLeft > 0) {
                    setTimeLeft(examData.timeLeft);
                } else {
                    setExamStarted(true);
                }

                // Set countdown and stop loading when data is ready
                setCountdown(examData.remainingTime || 0);

                setLoading(false);  // Set loading to false after the data is successfully fetched
            } catch (error) {
                console.error("Error fetching data", error);
                setLoading(false);  // Stop loading even in case of an error
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
                <title>{examData ? `${examData.examName}` : 'Loading Exam...'}</title>
            </Helmet>
            <div className="wrapper">
                {loading && <ExamLoading />}  {/* Show loading spinner while data is being fetched */}
                {!loading && (
                    <>
                        <ExamNavbar examTitle={examData ? examData.examName : 'Not Available'} />
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
