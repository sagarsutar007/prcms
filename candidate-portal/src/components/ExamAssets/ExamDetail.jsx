import { useEffect, useState } from "react";
import { Container, Row, Col, Card, Button } from "react-bootstrap";

const ExamDetail = ({ examData, countdown, onExamStarted }) => {
    const [roundedCountdown, setCountdown] = useState(Math.floor(countdown));

    useEffect(() => {
		if (roundedCountdown > 0) {
			const timer = setInterval(() => {
				setCountdown((prevCount) => {
					if (prevCount <= 1) {
						clearInterval(timer);
                        onExamStarted();
						return 0;
					}
					return prevCount - 1;
				});
			}, 1000);

			return () => clearInterval(timer);
		}
	}, [roundedCountdown]);
    return (
        <Container>
            <Row>
                <Col xs={12} md={6} className="mx-auto">
                    <Card>
                        <Card.Body>
                            <Card.Title>{examData?.examName}</Card.Title>
                            <Card.Text>
                                <strong>Number of Questions:</strong> {examData?.totalQuestions}<br/>
                                <strong>Exam Duration:</strong> {examData?.duration} minutes<br/>
                                <strong>Language:</strong> {examData?.language}
                            </Card.Text>
                            <Button variant="primary" disabled={roundedCountdown > 0}>
                                {roundedCountdown > 0 ? `Start Exam in ${roundedCountdown} seconds` : 'Start Exam'}
                            </Button>
                        </Card.Body>
                    </Card>
                </Col>
            </Row>
        </Container>
    );
}

export default ExamDetail;
