import { Helmet, HelmetProvider } from "react-helmet-async";
import { BsEye, BsEyeSlash } from "react-icons/bs";
import { Container, Row, Col, Form, Button } from "react-bootstrap";
import { Link, useNavigate } from "react-router-dom";
import { useState } from "react";
import styles from "../../assets/css/auth.module.css";
import brandLogo from "../../assets/img/brand-logo-white.png";
const Register = () => {
	const navigate = useNavigate();
	const [fullname, setFullname] = useState("");
	const [email, setEmail] = useState("");
	const [phone, setPhone] = useState("");
	const [password, setPassword] = useState("");
	const [passwordVisible, setPasswordVisible] = useState(false);

	const handleNameChange = (e) => {
		setFullname(e.target.value);
	};

	const handleEmailChange = (e) => {
		setEmail(e.target.value);
	};

	const handlePhoneChange = (e) => {
		setPhone(e.target.value);
	};

	const handlePasswordChange = (e) => {
		setPassword(e.target.value);
	};

	const togglePasswordVisibility = () => {
		setPasswordVisible(!passwordVisible);
	};
	return (
		<HelmetProvider>
			<div className={styles.authContainer}>
				<Helmet>
					<title>Candidate Register</title>
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
												<h3 className={styles.authTitle}>
													Create your account
												</h3>
												<p className={styles.authSubText}>
													Use your information to create profile
												</p>
											</div>
											<Row>
												<Col xs={12}>
													<Form className={styles.loginForm}>
														<Form.Group>
															<Form.Control
																type="text"
																name="fullname"
																value={fullname}
																className={styles.formControl}
																placeholder="Full Name"
																onChange={handleNameChange}
															/>
														</Form.Group>
														<Form.Group>
															<Form.Control
																type="email"
																name="email"
																value={email}
																className={styles.formControl}
																placeholder="Email"
																onChange={handleEmailChange}
															/>
														</Form.Group>
														<Form.Group>
															<Form.Control
																type="number"
																name="phone"
																value={phone}
																className={styles.formControl}
																placeholder="Phone Number"
																onChange={handlePhoneChange}
															/>
														</Form.Group>
														<Form.Group>
															<div className={styles.pwdMask}>
																<Form.Control
																	type={passwordVisible ? "text" : "password"}
																	name="password"
																	value={password}
																	className={styles.formControl}
																	placeholder="Password"
																	onChange={handlePasswordChange}
																/>
																<span
																	className={styles.pwdToggle}
																	onClick={togglePasswordVisibility}
																	style={{ cursor: "pointer" }}
																>
																	{passwordVisible ? <BsEyeSlash /> : <BsEye />}
																</span>
															</div>
														</Form.Group>
														<Form.Group>
															<Button
																className={`btn w-100 btn-lg ${styles.btnPrimary} ${styles.authfyLoginButton}`}
																type="button"
																onClick={() => navigate("/personal-detail")}
															>
																Register as Candidate
															</Button>
															<p className={`${styles.authSubText} my-3`}>
																Already have an account?&nbsp;
																<Link className="lnk-toggler" to="/login">
																	Login Here
																</Link>
															</p>
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

export default Register;
