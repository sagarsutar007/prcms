import { Helmet, HelmetProvider } from "react-helmet-async";
import { decrypt } from "../../utils/cryptoUtils";
import { Container, Row, Col, Form, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import styles from "../../assets/css/auth.module.css";
import AuthfyBrand from "../AuthfyBrand";
import axios from "axios";
const PersonalDetail = () => {
	const navigate = useNavigate();
	const [dob, setDob] = useState("");
	const [highestQualification, setHighestQualification] = useState("");
	const [gender, setGender] = useState("");
	const [userId, setUserId] = useState("");
	const [file, setFile] = useState([]);

	// State for tracking field validity
	const [isDobValid, setDobValid] = useState(true);
	const [isGenderValid, setGenderValid] = useState(true);

	useEffect(() => {
		const encryptedUserId = localStorage.getItem("userId");
		handleUserIdDecryption(encryptedUserId, setUserId, navigate);
	}, [navigate]);

	useEffect(() => {
		if (userId) {
			axios
				.get(
					process.env.SERVER_API_URL + `get-candidate-details?userId=${userId}`
				)
				.then((response) => {
					setHighestQualification(response.data.userdata.highest_qualification);
					setGender(response.data.userdata.gender);
					if (
						response.data.userdata.dob == null ||
						response.data.userdata.dob == undefined ||
						response.data.userdata.dob == "0000-00-00"
					) {
						console.log("DOB is Invalid");
					} else {
						const dobString = response.data.userdata.dob;
						const dobDate = new Date(dobString);
						const dobFormatted = dobDate.toISOString().split("T")[0];
						setDob(dobFormatted);
					}
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

	const handleQualificationChange = (event) => {
		setHighestQualification(event.target.value);
	};

	const handleGenderChange = (event) => {
		setGender(event.target.value);
	};

	const handleDOBChange = (event) => {
		setDob(event.target.value);
	};

	const handleFileChange = (event) => {
		setFile(event.target.files[0]); // Set selected file to state
	};

	const handleProfileUpdate = async () => {
		// Validate fields before submitting
		const isDobValid = dob.trim() !== "";
		const isGenderValid = gender.trim() !== "";

		setDobValid(isDobValid);
		setGenderValid(isGenderValid);

		if (!dob || !gender) {
			return;
		}

		try {
			const formData = new FormData();
			formData.append("gender", gender);
			formData.append("dob", dob);
			formData.append("highestQualification", highestQualification);
			formData.append("userId", userId);
			if (file) {
				formData.append("file", file);
			}

			const response = await axios.post(
				process.env.SERVER_API_URL + "update-personal-info",
				formData,
				{
					headers: {
						"Content-Type": "multipart/form-data",
					},
				}
			);

			if (response.data.status) {
				navigate(`/organisation-detail`);
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
													<Form
														className={styles.loginForm}
														encType="multipart/form-data"
													>
														<Form.Group>
															<Form.Select
																name="highest_qualification"
																aria-label="Select highest qualification"
																value={highestQualification || ""}
																className={styles.formSelect}
																onChange={handleQualificationChange}
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
																value={gender || ""}
																className={styles.formSelect}
																onChange={handleGenderChange}
																style={{
																	borderColor: isGenderValid ? "" : "red",
																	backgroundColor: isGenderValid
																		? ""
																		: "#ffe3e3",
																}}
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
																style={{
																	borderColor: isDobValid ? "" : "red",
																	backgroundColor: isDobValid ? "" : "#ffe3e3",
																}}
															/>
														</Form.Group>
														<Form.Group controlId="formFileLg" className="mb-3">
															<Form.Control
																type="file"
																name="file"
																size="lg"
																onChange={handleFileChange}
															/>
														</Form.Group>
														<Form.Group>
															<Button
																className={`btn w-100 btn-lg ${styles.btnPrimary} ${styles.authfyLoginButton}`}
																type="button"
																onClick={handleProfileUpdate}
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
