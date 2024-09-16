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

const ExamScreen = () => {
    const { examUrl } = useParams();
    const [examData, setExamData] = useState();
    const [timeLeft, setTimeLeft] = useState(null);
    const [examStarted, setExamStarted] = useState(false);

    const dispatch = useDispatch();

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(process.env.SERVER_API_URL + "load-exam-questions/" + examUrl, {
                    headers: {
                        "x-auth-token": localStorage.getItem("token"),
                    },
                });
                setExamData(response.data);
              
                dispatch(setQuestions(response.data.examQuestions));

                if (response.data.timeLeft > 0) {
                    setTimeLeft(response.data.timeLeft);
                } else {
                    setExamStarted(true);
                }
            } catch (error) {
                console.error("Error fetching data", error);
            }
        };

        fetchData();
    }, [examUrl, dispatch]);

    return (
        <HelmetProvider>
            <Helmet>
                <title>{examData ? `${examData.examName}` : 'Loading Exam...'}</title>
            </Helmet>
            <div className="wrapper">
                <ExamNavbar examTitle={examData ? examData.examName : 'Not Available'} />
                <ExamSidebar />
                <ExamQuestion />
                <ExamFooter/>
            </div>
        </HelmetProvider>
    );
};

export default ExamScreen;
