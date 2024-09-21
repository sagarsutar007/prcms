import { useEffect, useState } from "react";
import { useSelector, useDispatch } from 'react-redux';
import { nextQuestion, prevQuestion } from '../../features/exam/examSlice';
import { Card, Col, Container, Row, Button, Form } from "react-bootstrap";
import { useParams } from 'react-router-dom';
import axios from 'axios';

const ExamQuestion = ({ questions }) => {
    const dispatch = useDispatch();
    const currentQuestionIndex = useSelector((state) => state.exam.currentIndex);
    const examQues = useSelector((state) => state.exam.questions);
    const [selectedAnswer, setSelectedAnswer] = useState('');
    const { examUrl } = useParams();

    useEffect(() => {
        if (examQues.length > 0) {
            console.log("Current Question:", examQues[currentQuestionIndex]);
        }
    }, [currentQuestionIndex, examQues]);

    const handleNextQuestion = () => {
        if (currentQuestionIndex < examQues.length - 1) {
            dispatch(nextQuestion());
        } else {
            alert("Do you want to submit your exam paper?");
        }
    };

    const handlePrevQuestion = () => {
        if (currentQuestionIndex > 0) {
            dispatch(prevQuestion());
        }
    };

    const handleSubmitQuestion = () => {
        const currentQuestion = examQues[currentQuestionIndex];
        
        const data = JSON.stringify({
            "answerId": selectedAnswer,
            "questionId": currentQuestion.question_id
        });

        const config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: process.env.SERVER_API_URL + `submit-answer/${ examUrl }`,
            headers: { 
                'x-auth-token': localStorage.getItem("token"),
                'Content-Type': 'application/json'
            },
            data: data
        };

        axios.request(config)
            .then((response) => {
                console.log("Answer submitted successfully:", response.data);
                // Move to the next question after submitting
                // handleNextQuestion();
            })
            .catch((error) => {
                console.error("Error submitting answer:", error);
            });
    };

    const handleAnswerChange = (event) => {
        const newAnswer = event.target.value;
        setSelectedAnswer(newAnswer);
        
        // Only submit if there was no previous selection or if it’s a new selection
        if (selectedAnswer !== newAnswer) {
            handleSubmitQuestion();
        }
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
                    <Col xs={6} className="text-md-right">
                        <Button className="btn btn-primary ml-2" onClick={handleNextQuestion}>
                            Next Question
                        </Button>
                    </Col>
                </Row>
            </Container>
        </div>
    );
};

export default ExamQuestion;
