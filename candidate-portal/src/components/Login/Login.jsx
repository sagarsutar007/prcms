import { Helmet, HelmetProvider } from "react-helmet-async";
import styles from "../../assets/css/auth.module.css";
import brandLogo from "../../assets/img/brand-logo-white.png";
import { Link } from "react-router-dom";
import { useState } from "react";
import { BsEye, BsEyeSlash } from "react-icons/bs";
import { Container, Row, Col, Form, Button } from "react-bootstrap";

function Login() {
	const [phone, setPhone] = useState("");
	const [password, setPassword] = useState("");
	const [passwordVisible, setPasswordVisible] = useState(false);

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
					<title>Candidate Login</title>
				</Helmet>
				<Container fluid>
					<Row className="d-flex align-items-center Justify-content-center">
						<Col
							xs={{ span: 10, offset: 1 }}
							sm={{ span: 10, offset: 1 }}
							md={{ span: 8, offset: 2 }}
							lg={{ span: 6, offset: 3 }}
							className={styles.authfyContainer}
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
													Login to your account
												</h3>
												<p className={styles.authSubText}>
													Dont have an account?&nbsp;
													<Link className="lnk-toggler" to="/register">
														Sign Up Now!
													</Link>
												</p>
											</div>
											<Row>
												<Col xs={12}>
													<Form className={styles.loginForm}>
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
														<Row className={styles.rememberRow}>
															<Col xs={6} sm={6}>
																<Form.Check
																	type="checkbox"
																	id="remember"
																	label="Remember me"
																/>
															</Col>
															<Col xs={6} sm={6}>
																<p className={styles.forgotPwd}>
																	<Link
																		className={styles.lnkToggler}
																		to="/forgot-password"
																	>
																		Forgot password?
																	</Link>
																</p>
															</Col>
														</Row>
														<Form.Group>
															<Button
																className={`btn w-100 btn-lg ${styles.btnPrimary} ${styles.authfyLoginButton}`}
																type="submit"
															>
																Login as Candidate
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
}

export default Login;
