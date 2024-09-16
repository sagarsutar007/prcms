import { useEffect,useState } from "react";
import { useSelector, useDispatch } from 'react-redux';
import { nextQuestion, prevQuestion } from '../../features/exam/examSlice';
import { Card, Col, Container, Row, Button, Form } from "react-bootstrap";

const ExamQuestion = ({ questions }) => {
    const dispatch = useDispatch();
    const currentQuestionIndex = useSelector((state) => state.exam.currentIndex);
    const examQues = useSelector((state) => state.exam.questions);
    const [selectedAnswer, setSelectedAnswer] = useState('');

    // useEffect(() => {
    //     // dispatch(setQuestions(questions));
    //     console.log(examQues);
    // }, [questions, dispatch]);

    useEffect(() => {
        if (examQues.length > 0) {
            console.log("Current Question:", examQues[currentQuestionIndex]);
        }
    }, [currentQuestionIndex, examQues]);

    const handleNextQuestion = () => {
        if (currentQuestionIndex < examQues.length - 1) {
            dispatch(nextQuestion());
        } else {
            alert("You have reached the end of the exam.");
        }
    };

    const handlePrevQuestion = () => {
        if (currentQuestionIndex > 0) {
            dispatch(prevQuestion());
        }
    };

    const handleSubmitQuestion = () => {
        // submit answers code here
        handleNextQuestion();
    };

    const handleSkipQuestion = () => {
        handleNextQuestion();
    };

    const handleAnswerChange = (event) => {
        setSelectedAnswer(event.target.value);
    };

    const currentQuestion = examQues[currentQuestionIndex];

    return (
        <div className="content">
            <Container fluid>
                <Row className="my-3">
                    <Col lg={6} id="column1">
                        <Card className="card-primary card-outline">
                            <Card.Body>
                                <h5 className="card-title font-weight-bold">
                                    {currentQuestion ? currentQuestion.question_en : "Loading question..."}
                                </h5>
                            </Card.Body>
                        </Card>
                    </Col>
                    <Col lg={6} id="column2">
                        <Card className="card-primary card-outline">
                            <Card.Header>Choose the correct answer below:</Card.Header>
                            <Card.Body>
                                {currentQuestion && currentQuestion.question_type === "mcq" ? (
                                    <Form>
                                        {currentQuestion.answers.map((answer) => (
                                            <Form.Check
                                                key={answer.id}
                                                type="radio"
                                                label={answer.answer_text_en}
                                                name="answer"
                                                value={answer.id}
                                                checked={selectedAnswer === answer.id.toString()}
                                                onChange={handleAnswerChange}
                                            />
                                        ))}
                                    </Form>
                                ) : (
                                    <ul>
                                        {currentQuestion && currentQuestion.answers.map((answer) => (
                                            <li key={answer.id}>
                                                {answer.answer_text_en}
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </Card.Body>
                        </Card>
                    </Col>
                </Row>
                <Row className="mb-3">
                    <Col xs={6}>
                        <Button className="btn btn-primary" onClick={handlePrevQuestion} disabled={currentQuestionIndex === 0}>
                            Previous Question
                        </Button>
                    </Col>
                    <Col xs={6} className="text-right">
                        <Button className="btn btn-primary" onClick={handleSubmitQuestion}>
                            Submit Question
                        </Button>
                        <Button className="btn btn-secondary ml-2" onClick={handleSkipQuestion}>
                            Skip Question
                        </Button>
                    </Col>
                </Row>
            </Container>
        </div>
    );
};

export default ExamQuestion;
