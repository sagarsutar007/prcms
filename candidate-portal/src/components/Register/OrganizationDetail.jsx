import { Helmet, HelmetProvider } from "react-helmet-async";
import { Container, Row, Col, Form, Button } from "react-bootstrap";
import { decrypt } from "../../utils/cryptoUtils";
import { useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import styles from "../../assets/css/auth.module.css";
import AuthfyBrand from "../AuthfyBrand";
import axios from "axios";

const OrganizationDetail = () => {
	const navigate = useNavigate();
	const [empId, setEmpId] = useState("");
	const [companyId, setCompanyId] = useState("");
	const [userId, setUserId] = useState("");
	const [units, setUnits] = useState([]); // Initialize as an empty array

	// State for tracking field validity
	const [isEmpIdValid, setEmpValid] = useState(true);
	const [isCompanyIdValid, setCompanyValid] = useState(true);

	const handleEmpidChange = (e) => {
		setEmpId(e.target.value);
	};

	const handleCompanyIdChange = (e) => {
		setCompanyId(e.target.value);
	};

	useEffect(() => {
		const encryptedUserId = localStorage.getItem("userId");
		handleUserIdDecryption(encryptedUserId, setUserId, navigate);
	}, [navigate]);

	// Get organization details
	useEffect(() => {
		if (userId) {
			axios
				.get(process.env.SERVER_API_URL + `get-business-units?userId=${userId}`)
				.then((response) => {
					setUnits(response.data.units);
				})
				.catch((error) => {
					console.error("Failed to fetch user data:", error);
				});
		}
	}, [userId]);

	function handleUserIdDecryption(encryptedUserId, setUserId, navigate) {
		if (encryptedUserId) {
			try {
				const decryptedUserId = decrypt(encryptedUserId);
				setUserId(decryptedUserId);
			} catch (error) {
				console.error("Decryption failed:", error);
				navigate("/register");
			}
		} else {
			navigate("/register");
		}
	}

	const handleOrganizationUpdate = async () => {
		// Validate fields before submitting
		const isEmpIdValid = empId.trim() !== "";
		const isCompanyIdValid = companyId.trim() !== "";

		setEmpValid(isEmpIdValid);
		setCompanyValid(isCompanyIdValid);

		if (!isEmpIdValid || !isCompanyIdValid) {
			return;
		}

		try {
			const response = await axios.post(
				process.env.SERVER_API_URL + "update-organisation-info",
				{
					empId: empId,
					companyId: companyId,
					userId: userId,
				}
			);

			if (response.data.status) {
				navigate(`/login`);
			} else {
				alert(response.data.message || "Registration failed!");
			}
		} catch (error) {
			console.log(error);
			alert(
				error.response?.data?.error || "An error occurred during registration."
			);
		}
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
																name="company_id"
																aria-label="Select business unit"
																value={companyId || ""}
																className={styles.formSelect}
																onChange={handleCompanyIdChange}
																style={{
																	borderColor: isCompanyIdValid ? "" : "red",
																	backgroundColor: isCompanyIdValid
																		? ""
																		: "#ffe3e3",
																}}
															>
																<option value="" hidden>
																	Select business unit
																</option>
																{Array.isArray(units) &&
																	units.map((unit) => (
																		<option key={unit.id} value={unit.id}>
																			{unit.company_name}
																		</option>
																	))}
															</Form.Select>
														</Form.Group>
														<Form.Group>
															<Form.Control
																type="text"
																name="empid"
																value={empId}
																className={styles.formControl}
																placeholder="Employee Id"
																onChange={handleEmpidChange}
																style={{
																	borderColor: isEmpIdValid ? "" : "red",
																	backgroundColor: isEmpIdValid
																		? ""
																		: "#ffe3e3",
																}}
															/>
														</Form.Group>
														<Form.Group>
															<Button
																className={`btn w-100 btn-lg ${styles.btnPrimary} ${styles.authfyLoginButton}`}
																type="button"
																onClick={handleOrganizationUpdate}
															>
																Complete Registration
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
