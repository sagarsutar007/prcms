import { useParams, useNavigate } from "react-router-dom";
import { Helmet, HelmetProvider } from "react-helmet-async";
import { useEffect, useState } from "react";
import axios from "axios";
import ExamNavbar from "./ExamAssets/ExamNavbar";
import ExamSidebar from "./ExamAssets/ExamSidebar";
import ExamFooter from "./ExamAssets/ExamFooter";
import ExamQuestion from "./ExamAssets/ExamQuestion";
import ExamDetail from "./ExamAssets/ExamDetail";
import ExamOver from "./ExamAssets/ExamOver"; // Import ExamOver screen

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
  const [countdown, setCountdown] = useState(5000);
  const [examOver, setExamOver] = useState(false); 
  const [language, setLanguage] = useState("en"); // Language state

  const navigate = useNavigate();
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

        const examToken = examData.examToken; 
        const storedExamToken = localStorage.getItem("examToken");

        if (examToken) {
          if (examToken !== storedExamToken) {
            alert("Exam is ongoing on another device. Please try again later.");
            navigate("/student-dashboard");
            return;
          }
        }

        if (examData.leftAt) {
          setExamOver(true);
        } else if (examData.remainingTime > 0) {
          setTimeLeft(examData.remainingTime);
          setLoading(false);
        } else {
          setExamStarted(true);
          startExamAPI(examData.examId);
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
            startExamAPI(examData.examId);
            setExamStarted(true);
            return 0;
          }
          return prevCount - 1;
        });
      }, 1000);

      return () => clearInterval(timer);
    }
  }, [countdown]);

  const startExamAPI = async (examId) => {
    if (!examId) {
      console.error("Exam ID is not available.");
      return;
    }
    try {
      const response = await axios.post(
        process.env.SERVER_API_URL + "start-paper",
        { examId },
        {
          headers: {
            "x-auth-token": localStorage.getItem("token"),
          },
        }
      );

      console.log(response);

      if (response.status === 200) {
        localStorage.setItem("examToken", response.data.authToken);
      } else {
        navigate('student-dashboard');
      }
    } catch (error) {
      console.error("Error starting the exam", error);
    }
  };

  const handleTimerEnd = () => {
    setExamOver(true);
  };

  const startExam = () => {
    setExamStarted(true);
  };

  const handleExamSubmission = async () => {
    try {
      const response = await axios.post(
        process.env.SERVER_API_URL + "submit-paper", 
        { examId: examData.examId },
        {
          headers: {
            "x-auth-token": localStorage.getItem("token"),
          },
        }
      );
        
      if (response.status === 200) {
        setExamOver(true);
        console.log("Exam submitted successfully");
      }
    } catch (error) {
      console.error("Error submitting the exam", error);
    }
  };

  return (
    <HelmetProvider>
      <Helmet>
        <title>{examData ? `${examData.examName}` : "Loading Exam..."}</title>
      </Helmet>
      <div className="wrapper">
        {loading && <ExamLoading />}
        
        {!loading && !examStarted && !examOver && (
          <ExamDetail examData={examData} countdown={timeLeft} onExamStarted={startExam} />
        )}
        
        {!loading && examStarted && !examOver && (
          <>
            <ExamNavbar
              examTitle={examData ? examData.examName : "Not Available"}
              examStartTime={examData ? examData.examStartTime : "00:00"}
              examEndTime={examData ? examData.examEndTime : "00:00"}
              onTimerEnd={handleTimerEnd}
              language={language}
              setLanguage={setLanguage}
            />
            <ExamSidebar />
            <ExamQuestion onExamExit={handleExamSubmission} language={language} />
            <ExamFooter />
          </>
        )}
              
        {!loading && examOver && <ExamOver />}
      </div>
    </HelmetProvider>
  );
};

export default ExamScreen;
