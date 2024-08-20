import brandLogo from "../assets/img/brand-logo-white.png";
import styles from "../assets/css/auth.module.css";
const AuthfyBrand = () => {
	return (
		<div className={styles.brandCol}>
			<div className={styles.headline}>
				<div className={`${styles.brandLogo} text-center`}>
					<img src={brandLogo} width="95px" alt="brand-logo" />
				</div>
				<p className={`${styles.authSubText} text-center text-white`}>
					Your Next Milestone
				</p>
			</div>
		</div>
	);
};

export default AuthfyBrand;
