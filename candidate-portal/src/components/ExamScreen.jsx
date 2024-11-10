import { useParams, useNavigate } from "react-router-dom";
import { Helmet, HelmetProvider } from "react-helmet-async";
import { useEffect, useState, useCallback, useMemo } from "react";
import axios from "axios";
import ExamNavbar from "./ExamAssets/ExamNavbar";
import ExamSidebar from "./ExamAssets/ExamSidebar";
import ExamFooter from "./ExamAssets/ExamFooter";
import ExamQuestion from "./ExamAssets/ExamQuestion";
import ExamDetail from "./ExamAssets/ExamDetail";
import ExamOver from "./ExamAssets/ExamOver";
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
  const [language, setLanguage] = useState("en");

  const navigate = useNavigate();
  const dispatch = useDispatch();

  const handleInvalidToken = useCallback((error) => {
    if (
      error.response &&
      error.response.data &&
      error.response.data.errors &&
      error.response.data.errors.some(err => err.msg === "Invalid token")
    ) {
      navigate("/logout");
    }
  }, [navigate]);

  // Memoize API calls
  const startExamAPI = useCallback(async (examId) => {
    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/logout");
      return;
    }

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

      if (response.status === 200) {
        localStorage.setItem("examToken", response.data.authToken);
      } else {
        navigate('logout');
      }
    } catch (error) {
      console.error("Error starting the exam", error);
      handleInvalidToken(error);
      navigate("/logout");
    }
  }, [navigate, handleInvalidToken]);

  const handleExamSubmission = useCallback(async () => {
    try {
      const response = await axios.post(
        process.env.SERVER_API_URL + "submit-paper",
        { examId: examData?.examId },
        {
          headers: {
            "x-auth-token": localStorage.getItem("token"),
          },
        }
      );

      if (response.status === 200) {
        setExamOver(true);
      }
    } catch (error) {
      console.error("Error submitting the exam", error);
    }
  }, [examData?.examId]);

  // Memoize event handlers
  const handleTimerEnd = useCallback(() => {
    setExamOver(true);
  }, []);

  const startExam = useCallback(() => {
    setExamStarted(true);
  }, []);

  // Fetch exam data
  useEffect(() => {
    const fetchData = async () => {
      const token = localStorage.getItem("token");
      if (!token) {
        navigate("/logout");
        return;
      }

      try {
        const response = await axios.get(
          process.env.SERVER_API_URL + "load-exam-questions/" + examUrl,
          {
            headers: {
              "x-auth-token": localStorage.getItem("token"),
            },
          }
        );

        if (response.status != 200) {
          navigate("/logout");
        }

        const examData = response.data;
        setExamData(examData);
        dispatch(setQuestions(examData.examQuestions));

        const examToken = examData.examToken;
        const storedExamToken = localStorage.getItem("examToken");

        if (examToken && examToken !== storedExamToken) {
          alert("Exam is ongoing on another device. Please try again later.");
          navigate("/student-dashboard");
          return;
        }

        if (examData.leftAt != null && examData.leftAt !== "") {
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
        handleInvalidToken(error);
        navigate("/logout");
      }
    };

    fetchData();
  }, [examUrl, dispatch, navigate, startExamAPI, handleInvalidToken]);

  // Countdown timer
  useEffect(() => {
    if (countdown > 0) {
      const timer = setInterval(() => {
        setCountdown((prevCount) => {
          if (prevCount <= 1) {
            clearInterval(timer);
            if (examData?.examId) {
              startExamAPI(examData.examId);
              setExamStarted(true);
            }
            return 0;
          }
          return prevCount - 1;
        });
      }, 1000);

      return () => clearInterval(timer);
    }
  }, [countdown, examData?.examId, startExamAPI]);

  // Memoize navbar props
  const navbarProps = useMemo(() => ({
    examTitle: examData?.examName || "Not Available",
    examStartTime: examData?.examStartTime || "00:00",
    examEndTime: examData?.examEndTime || "00:00",
    onTimerEnd: handleTimerEnd,
    language,
    setLanguage
  }), [examData?.examName, examData?.examStartTime, examData?.examEndTime, handleTimerEnd, language]);

  return (
    <HelmetProvider>
      <Helmet>
        <title>{examData ? `${examData.examName}` : "Loading Exam..."}</title>
      </Helmet>
      <div className="wrapper">
        {loading && <ExamLoading />}

        {!loading && !examStarted && !examOver && (
          <ExamDetail
            examData={examData}
            countdown={timeLeft}
            onExamStarted={startExam}
          />
        )}

        {!loading && examStarted && !examOver && (
          <>
            <ExamNavbar {...navbarProps} />
            <ExamSidebar />
            <ExamQuestion
              onExamExit={handleExamSubmission}
              language={language}
            />
            <ExamFooter />
          </>
        )}

        {!loading && examOver && <ExamOver />}
      </div>
    </HelmetProvider>
  );
};

export default ExamScreen;