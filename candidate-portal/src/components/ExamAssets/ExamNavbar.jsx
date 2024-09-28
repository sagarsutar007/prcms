import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

const ExamNavbar = ({ examTitle, examStartTime, onTimerEnd }) => {

	const [timeRemaining, setTimeRemaining] = useState("");

	useEffect(() => {
		// Apply 'sidebar-collapse' class to body
		document.body.classList.add("sidebar-collapse");

		// Cleanup function to remove 'sidebar-collapse' class on unmount
		return () => {
			document.body.classList.remove("sidebar-collapse");
		};
	}, []);

	useEffect(() => {
		// Parse examStartTime
		const startTime = new Date(examStartTime).getTime();

		// Update the countdown every second
		const interval = setInterval(() => {
			const currentTime = new Date().getTime();
			const timeDifference = startTime - currentTime;

			if (timeDifference > 0) {
				const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
				const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);
				setTimeRemaining(`${minutes}:${seconds < 10 ? "0" + seconds : seconds}`);
			} else {
				setTimeRemaining("00:00");
				clearInterval(interval);
				onTimerEnd(); // Notify the parent component when time is up
			}
		}, 1000);

		return () => {
			clearInterval(interval);
			document.body.classList.remove("sidebar-collapse");
		};
	}, [examStartTime, onTimerEnd]);


	return (
		<nav className="main-header navbar navbar-expand navbar-white navbar-light">
			<ul className="navbar-nav">
				<li className="nav-item">
					<a className="nav-link" data-widget="pushmenu" href="#" role="button">
						<i className="fas fa-bars"></i>
					</a>
				</li>
				<li className="nav-item">
					{/* d-none d-sm-inline-block */}
					<Link to="#" className="nav-link">
						{examTitle}
					</Link>
				</li>
			</ul>
			<ul className="navbar-nav ml-auto">
				<li className="nav-item">
					<Link className="nav-link" to="#" role="button">
						<span id="timer">{ timeRemaining }</span>
					</Link>
				</li>
				<li className="nav-item">
					<Link
						className="nav-link"
						data-widget="fullscreen"
						to="#"
						role="button"
					>
						<i className="fas fa-expand-arrows-alt"></i>
					</Link>
				</li>
			</ul>
		</nav>
	);
};

export default ExamNavbar;
