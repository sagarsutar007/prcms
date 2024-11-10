import { useState, useEffect } from "react";
import DashboardFooter from "./DashboardFooter";
import DashboardNavbar from "./DashboardNavbar";
import DashboardSidebar from "./DashboardSidebar";
import { Col, Row, Container, Card } from "react-bootstrap";
import { Helmet, HelmetProvider } from "react-helmet-async";
import ExamTable from "./ExamTable";
import axios from "axios";


function Dashboard() {
    const [data, setData] = useState([]);

    // Fetch exam data from your API
    useEffect(() => {
        const fetchData = async () => {
            const token = localStorage.getItem("token");

            if (!token) {
                // Redirect to logout if token is missing
                window.location.href = "/logout";
                return;
            }

            try {
                const response = await axios.get(`${process.env.SERVER_API_URL}candidate-exams`, {
                    headers: {
                        "x-auth-token": token,
                    },
                });

                if (response.data && response.data.exams) {
                    setData(response.data.exams);
                } else {
                    // Redirect to logout if exams data is missing
                    window.location.href = "/logout";
                }
            } catch (error) {
                console.error("Error fetching data:", error);
                window.location.href = "/logout";
            }
        };

        fetchData();
    }, []);


    return (
        <HelmetProvider>
            <Helmet>
                <title>Exams</title>
            </Helmet>
            <div className="wrapper">
                <DashboardNavbar />
                <DashboardSidebar />
                <div className="content-wrapper">
                    <section className="content">
                        <Container fluid>
                            <Row>
                                <Col lg={12} className="mt-3">
                                    <Card>
                                        <Card.Header>Exams</Card.Header>
                                        <Card.Body>
                                            <ExamTable data={data} />
                                        </Card.Body>
                                    </Card>
                                </Col>
                            </Row>

                        </Container>
                    </section>
                </div>
                <DashboardFooter />
            </div>
        </HelmetProvider>
    );
}

export default Dashboard;