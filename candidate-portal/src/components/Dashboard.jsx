import { useState, useEffect } from "react";
import { useSelector } from "react-redux";
import { Card, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import DashboardFooter from "./DashboardFooter";
import DashboardNavbar from "./DashboardNavbar";
import DashboardSidebar from "./DashboardSidebar";
import axios from "axios";

function Dashboard() {
    const userDetails = useSelector((state) => state.auth.userDetails);
    const fullName = userDetails ? userDetails.fullName : "User";
    const [examData, setExamData] = useState(null);
    const navigate = useNavigate();

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(process.env.SERVER_API_URL + "candidate-exam", {
                    headers: {
                        "x-auth-token": localStorage.getItem("token"),
                    },
                });
                console.log("API Response:", response.data); // Debugging line
                setExamData(response.data.exam);
            } catch (error) {
                console.error("Error fetching data", error);
            }
        };

        fetchData();
    }, []);

    const convertToIST = (dateTime) => {
		const date = new Date(dateTime);
		
		// Get the UTC time components
		const utcDate = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 
								date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
		
		// Convert to IST (UTC + 5:30)
		const istDate = new Date(utcDate.getTime() + 5.5 * 60 * 60 * 1000);
		return istDate;
	};

	const getExamStatus = (exam) => {
		if (!exam) return "No exam available";

		const currentIST = new Date();
		const examStartTime = convertToIST(exam.exam_datetime);
		const examEndTime = convertToIST(exam.exam_endtime);

		console.log("Current IST:", currentIST);
		console.log("Exam Start Time IST:", examStartTime);
		console.log("Exam End Time IST:", examEndTime);
		
		// Log the comparison results
		const isUpcoming = currentIST < examStartTime;
		const isOngoing = currentIST >= examStartTime && currentIST <= examEndTime;

		if (isUpcoming) {
			return "upcoming"; // Exam is upcoming
		} else if (isOngoing) {
			return "ongoing"; // Exam is ongoing
		} else {
			return "ended"; // Exam has ended
		}
	};

    const handleExamNavigate = () => {
        if (examData) {
            navigate(`/exam/${examData.url}`);
        }
    };

    const examStatus = examData ? getExamStatus(examData) : null;

    return (
        <div className="wrapper">
            <DashboardNavbar />
            <DashboardSidebar />
            <div className="content-wrapper">
                <section className="content">
                    <div className="container-fluid">
                        <div className="row">
                            <div className="col-12 col-md-7">
                                <Card className="mt-3">
                                    <Card.Body>
                                        <Card.Title className="h3">
                                            Welcome, {fullName}!
                                        </Card.Title>
                                        <br />
                                        {examData && examStatus && examStatus !== "ended" && (
                                            <div className="text-sm text-start">
                                                <p>
                                                    You have an {examStatus} exam: {examData.name}.
                                                </p>
                                                <Button variant="primary" onClick={handleExamNavigate}>
                                                    Jump to Exam
                                                </Button>
                                            </div>
                                        )}
                                        {examStatus === "ended" && (
                                            <p className="text-danger">Your exam has ended.</p>
                                        )}
                                    </Card.Body>
                                </Card>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <DashboardFooter />
        </div>
    );
}

export default Dashboard;
