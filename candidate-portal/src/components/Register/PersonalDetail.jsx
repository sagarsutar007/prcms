import { Helmet, HelmetProvider } from "react-helmet-async";
import { decrypt } from "../../utils/cryptoUtils";
import { Container, Row, Col, Form, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import styles from "../../assets/css/auth.module.css";
import brandLogo from "../../assets/img/brand-logo-white.png";
import FileUpload from "../FileUpload";
import AuthfyBrand from "../AuthfyBrand";
const PersonalDetail = () => {
	const navigate = useNavigate();
	const [dob, setDob] = useState("");
	const [userId, setUserId] = useState(null);

	const handleDOBChange = (e) => {
		setDob(e.target.value);
	};

	useEffect(() => {
		const encryptedUserId = localStorage.getItem("userId");
		if (encryptedUserId) {
			try {
				const decryptedUserId = decrypt(encryptedUserId);
				setUserId(decryptedUserId);
				console.log(userId);
			} catch (error) {
				console.error("Decryption failed:", error);
				navigate("/register");
			}
		} else {
			navigate("/register");
		}
	}, [navigate]);

	return (
		<HelmetProvider>
			<div className={styles.authContainer}>
				<Helmet>
					<title>Personal Detail</title>
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
									<AuthfyBrand />
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
																name="highest_qualification"
																aria-label="Select highest qualification"
																defaultValue=""
																className={styles.formSelect}
															>
																<option value="" disabled hidden>
																	Select Qualification
																</option>
																<option value="10th Pass">10th Pass</option>
																<option value="12th pass">12th pass</option>
																<option value="10th + ITI">10th + ITI</option>
																<option value="12+ ITI">12+ ITI</option>
																<option value="B.A">B.A</option>
																<option value="B.COM">B.COM</option>
																<option value="BBA">BBA</option>
																<option value="BCA">BCA</option>
																<option value="B.SC">B.SC</option>
																<option value="B.TECH">B.TECH</option>
																<option value="MBA">MBA</option>
																<option value="MCA">MCA</option>
																<option value="M.A">M.A</option>
																<option value="M.COM">M.COM</option>
																<option value="Any Graduation">
																	Any Graduation
																</option>
																<option value="Diploma">Diploma</option>
															</Form.Select>
														</Form.Group>
														<Form.Group>
															<Form.Select
																name="gender"
																aria-label="Select gender"
																defaultValue=""
																className={styles.formSelect}
															>
																<option value="" disabled hidden>
																	Select Gender
																</option>
																<option value="male">Male</option>
																<option value="female">Female</option>
																<option value="transgender">Transgender</option>
															</Form.Select>
														</Form.Group>
														<Form.Group>
															<Form.Control
																type="date"
																name="dob"
																value={dob}
																className={styles.formControl}
																placeholder="Date of Birth"
																onChange={handleDOBChange}
															/>
														</Form.Group>
														<FileUpload />
														<Form.Group>
															<Button
																className={`btn w-100 btn-lg ${styles.btnPrimary} ${styles.authfyLoginButton}`}
																type="button"
																onClick={() => navigate("organisation-detail")}
															>
																Proceed to Final Step
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

export default PersonalDetail;
