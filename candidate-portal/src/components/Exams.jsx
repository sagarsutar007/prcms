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
        try {
            const response = await axios.get(process.env.SERVER_API_URL + "candidate-exams", {
                headers: {
                    "x-auth-token": localStorage.getItem("token"),
                },
            });
            setData(response.data.exams);
        } catch (error) {
            console.error("Error fetching data", error);
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