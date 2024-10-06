import { useEffect, useState } from "react";
import { Container, Row, Col, Card, Button } from "react-bootstrap";
import axios from "axios";

const ExamDetail = ({ examData, countdown, onExamStarted }) => {
    const [roundedCountdown, setCountdown] = useState(Math.floor(countdown));

    useEffect(() => {
        if (roundedCountdown > 0) {
            const timer = setInterval(() => {
                setCountdown((prevCount) => {
                    if (prevCount <= 1) {
                        clearInterval(timer);
                        // onExamStarted();
                        return 0;
                    }
                    return prevCount - 1;
                });
            }, 1000);

            return () => clearInterval(timer);
        }
    }, [roundedCountdown]);
    
    const formatCountdown = (count) => {
        const minutes = Math.floor(count / 60);
        const seconds = count % 60;
        return `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
    };

    const handleStartExam = () => {
        if (roundedCountdown === 0) {
            startExamAPI(examData.examId);
            onExamStarted();
        }
    }

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

            if (response.status === 200) {
                localStorage.setItem("examToken", response.data.authToken);
            } else {
                navigate('student-dashboard');
            }
        } catch (error) {
            console.error("Error starting the exam", error);
        }
    };

    return (
        <div className="overlay" style={{
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            height: "100vh"
        }}>
            <Container>
                <Row>
                    <Col xs={12} md={6} className="mx-auto">
                        <Card>
                            <Card.Body>
                                <h3>{examData?.examName}</h3>
                                <Card.Text>
                                    <strong>Total Questions:</strong> {examData?.examQuestionsCount}<br />
                                    <strong>Exam Duration:</strong> {examData?.examDuration} minutes<br />
                                    <strong>Available Language:</strong> {examData?.examLanguage === 'both' ? 'Hindi & English' : examData?.examLanguage}
                                </Card.Text>
                                <Button variant="primary" className="w-100" disabled={roundedCountdown > 0} onClick={() => {
                                    handleStartExam();
                                }}>
                                    {roundedCountdown > 0 ? `Exam starts in ${formatCountdown(roundedCountdown)}` : 'Start Exam'}
                                </Button>
                            </Card.Body>
                        </Card>
                    </Col>
                </Row>
            </Container>
        </div>
    );
}

export default ExamDetail;
