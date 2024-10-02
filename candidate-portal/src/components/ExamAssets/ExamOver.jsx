import React from "react";
import { Card, Container, Row, Col, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";

const ExamOver = () => {
  const navigate = useNavigate();

  const handleGoToDashboard = () => {
    navigate("/student-dashboard");
  };

  return (
    <div
      className="overlay"
      style={{
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        height: "100vh",
      }}
    >
      <Container>
        <Row>
          <Col xs={12} md={4}></Col>
          <Col xs={12} md={4}>
            <Card>
              <Card.Body>
                <div className="text-center">
                  <i
                    className="fas fa-check-circle text-success"
                    style={{ fontSize: "40px" }}
                  ></i>
                  <h5 className="text-secondary mt-3">Exam is over!</h5>
                  <Button
                    className="btn btn-primary btn-sm mt-2"
                    onClick={handleGoToDashboard}
                  >
                    Go to Dashboard
                  </Button>
                </div>
              </Card.Body>
            </Card>
          </Col>
        </Row>
      </Container>
    </div>
  );
};

export default ExamOver;
