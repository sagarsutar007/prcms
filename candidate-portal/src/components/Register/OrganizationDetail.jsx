import { Helmet, HelmetProvider } from "react-helmet-async";
import { Container, Row, Col, Form, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { useState } from "react";
import styles from "../../assets/css/auth.module.css";
import brandLogo from "../../assets/img/brand-logo-white.png";
const OrganizationDetail = () => {
	const navigate = useNavigate();
	const [empId, setEmpId] = useState("");

	const handleEmpidChange = (e) => {
		setEmpId(e.target.value);
	};

	return (
		<HelmetProvider>
			<div className={styles.authContainer}>
				<Helmet>
					<title>Organization Detail</title>
				</Helmet>
				<Container fluid>
					<Row className="">
						<Col
							xs={{ span: 10 }}
							sm={{ span: 10 }}
							md={{ span: 8 }}
							lg={{ span: 6 }}
							className={`${styles.authfyContainer} mx-auto`}
						>
							<Row>
								<Col sm={5} className={styles.authfyPanelLeft}>
									<div className={styles.brandCol}>
										<div className={styles.headline}>
											<div className={`${styles.brandLogo} text-center`}>
												<img src={brandLogo} width="95px" alt="brand-logo" />
											</div>
											<p className="text-center">Your Next Milestone</p>
										</div>
									</div>
								</Col>
								<Col sm={7} className={styles.authfyPanelRight}>
									<div className={styles.authfyLogin}>
										<div
											className={`${styles.authfyPanel} ${styles.panelLogin} text-center ${styles.active}`}
										>
											<div className={styles.authfyHeading}>
												<h3 className={styles.authTitle}>Personal Detail</h3>
												<p className={styles.authSubText}>
													Use your correct information
												</p>
											</div>
											<Row>
												<Col xs={12}>
													<Form className={styles.loginForm}>
														<Form.Group>
															<Form.Select
																name="company_id"
																aria-label="Select business unit"
																defaultValue=""
																className={styles.formSelect}
															>
																<option value="" disabled hidden>
																	Select business unit
																</option>
															</Form.Select>
														</Form.Group>
														<Form.Group>
															<Form.Control
																type="text"
																name="empid"
																value={empid}
																className={styles.formControl}
																placeholder="Employee Id"
																onChange={handleEmpidChange}
															/>
														</Form.Group>
														<Form.Group>
															<Button
																className={`btn w-100 btn-lg ${styles.btnPrimary} ${styles.authfyLoginButton}`}
																type="button"
																onClick={() => navigate("verify-phone")}
															>
																Verify Phone
															</Button>
														</Form.Group>
													</Form>
												</Col>
											</Row>
										</div>
									</div>
								</Col>
							</Row>
						</Col>
					</Row>
				</Container>
			</div>
		</HelmetProvider>
	);
};

export default OrganizationDetail;
