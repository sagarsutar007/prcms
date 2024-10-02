import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

const ExamNavbar = ({ examTitle, examStartTime, examEndTime, onTimerEnd }) => {
  const [timeRemaining, setTimeRemaining] = useState("");

  useEffect(() => {
    document.body.classList.add("sidebar-collapse");
    
    return () => {
      document.body.classList.remove("sidebar-collapse");
    };
  }, []);

    useEffect(() => {
		const adjustToIST = (time) => {
			const date = new Date(time);
			return new Date(date.toLocaleString("en-IN", { timeZone: "Asia/Kolkata" }));
		};

		// Adjust startTime and endTime to IST
		const startTime = adjustToIST(examStartTime).getTime();
		const endTime = adjustToIST(examEndTime).getTime();

		const interval = setInterval(() => {
			const now = adjustToIST(new Date()).getTime();
			const timeDifference = endTime - now;

			if (timeDifference > 0) {
				const hours = Math.floor(timeDifference / (1000 * 60 * 60));
				const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
				const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

				setTimeRemaining(`${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`);
			} else {
				setTimeRemaining("00:00:00");
				clearInterval(interval);
				onTimerEnd();
			}
		}, 1000);

		return () => {
			clearInterval(interval);
		};
	}, [examStartTime, examEndTime, onTimerEnd]);


  return (
    <nav className="main-header navbar navbar-expand navbar-white navbar-light">
      <ul className="navbar-nav">
        <li className="nav-item">
          <a className="nav-link" data-widget="pushmenu" href="#" role="button">
            <i className="fas fa-bars"></i>
          </a>
        </li>
        <li className="nav-item">
          <Link to="#" className="nav-link">
            {examTitle}
          </Link>
        </li>
      </ul>
      <ul className="navbar-nav ml-auto">
        <li className="nav-item">
          <Link className="nav-link" to="#" role="button">
            <span id="timer">{timeRemaining}</span>
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