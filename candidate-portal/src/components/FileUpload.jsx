import { Form } from "react-bootstrap";
import styles from "../assets/css/auth.module.css";
function FileUpload() {
	return (
		<Form.Group controlId="formFile" className="mb-3">
			<Form.Label className={styles.customFileLabel}>
				<span className={styles.placeholderText}>Passport Size Photo</span>
				<Form.Control
					type="file"
					style={{ height: 50, lineHeight: 2.3 }}
					className={styles.fileInput}
				/>
			</Form.Label>
		</Form.Group>
	);
}

export default FileUpload;
