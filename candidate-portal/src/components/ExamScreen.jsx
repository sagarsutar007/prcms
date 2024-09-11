import { useParams } from "react-router-dom";
import { Helmet, HelmetProvider } from "react-helmet-async";
import { useEffect, useState } from "react";
import axios from "axios";
import ExamNavbar from "./ExamAssets/ExamNavbar";
import ExamSidebar from "./ExamAssets/ExamSidebar";

const ExamScreen = () => {
    const { examUrl } = useParams();
    const [examData, setExamData] = useState();
    const [examQuestions, setExamQuestions] = useState();
    const [timeLeft, setTimeLeft] = useState(null);
    const [examStarted, setExamStarted] = useState(false);

    useEffect(() => {
      const fetchData = async () => {
          try {
              const response = await axios.get(process.env.SERVER_API_URL + "load-exam-questions/" + examUrl, {
                  headers: {
                      "x-auth-token": localStorage.getItem("token"),
                  },
              });
            setExamData(response.data);
            setExamQuestions(response.data.examQuestions);

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
    }, [examUrl]);
  
    // Log data after it's set
    useEffect(() => {
      if (examData) {
        console.log("Exam Data:", examData);
      }
      if (examQuestions) {
        console.log("Exam Questions:", examQuestions);
      }
    }, [examData, examQuestions]);

    return (
      <HelmetProvider>
          <Helmet>
              <title>{examData ? `${examData.examName}` : 'Loading Exam...'}</title>
          </Helmet>
          <div className="wrapper">
          <ExamNavbar examTitle={examData ? examData.examName : 'Not Available'} />
          <ExamSidebar questions={ examQuestions } />
          </div>
      </HelmetProvider>
  );
};

export default ExamScreen;