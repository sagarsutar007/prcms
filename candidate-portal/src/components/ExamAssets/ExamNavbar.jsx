import { useEffect, useState, useMemo } from "react";
import { Link } from "react-router-dom";

const ExamNavbar = ({ examTitle, examStartTime, examEndTime, onTimerEnd, language, setLanguage }) => {
  const [timeRemaining, setTimeRemaining] = useState("00:00:00");

  const translations = useMemo(() => ({
    en: {
      title: "Exam",
      timer: "Time Left",
    },
    hi: {
      title: "परीक्षा",
      timer: "समय शेष",
    },
  }), []);

  useEffect(() => {
    document.body.classList.add("sidebar-collapse");
    return () => {
      document.body.classList.remove("sidebar-collapse");
    };
  }, []);

  useEffect(() => {
    const parseDateTime = (timeStr) => {
      if (!timeStr) return null;
      try {
        const date = new Date(timeStr);
        return isNaN(date.getTime()) ? null : date;
      } catch (error) {
        console.error("Error parsing date:", error);
        return null;
      }
    };

    const start = parseDateTime(examStartTime);
    const end = parseDateTime(examEndTime);

    if (!start || !end) {
      console.error("Invalid start or end time", { examStartTime, examEndTime });
      return;
    }

    const calculateTimeRemaining = () => {
      const now = new Date();

      // If current time is before start time, don't start the timer
      if (now < start) {
        return {
          timeString: "Not started",
          isExpired: false,
          shouldStart: false
        };
      }

      // If current time is after end time, exam is over
      if (now > end) {
        return {
          timeString: "00:00:00",
          isExpired: true,
          shouldStart: false
        };
      }

      // Calculate remaining time
      const timeDifference = end.getTime() - now.getTime();
      const hours = Math.floor(timeDifference / (1000 * 60 * 60));
      const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

      return {
        timeString: `${hours.toString().padStart(2, "0")}:${minutes
          .toString()
          .padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`,
        isExpired: false,
        shouldStart: true
      };
    };

    // Initial calculation
    const initialTime = calculateTimeRemaining();
    setTimeRemaining(initialTime.timeString);

    // Only end the exam if it's actually over
    if (initialTime.isExpired) {
      onTimerEnd();
      return;
    }

    // Set up interval only if the exam should be running
    if (initialTime.shouldStart) {
      const interval = setInterval(() => {
        const result = calculateTimeRemaining();
        setTimeRemaining(result.timeString);

        if (result.isExpired) {
          clearInterval(interval);
          console.log("Test 2");
          onTimerEnd();
        }
      }, 1000);

      return () => clearInterval(interval);
    }
  }, [examStartTime, examEndTime, onTimerEnd]);

  const handleLanguageChange = useMemo(() => (
    (e) => setLanguage(e.target.value)
  ), [setLanguage]);

  return (
    <nav className="main-header navbar navbar-expand navbar-white navbar-light">
      <ul className="navbar-nav">
        <li className="nav-item">
          <a className="nav-link" data-widget="pushmenu" href="#" role="button">
            <i className="fas fa-bars"></i>
          </a>
        </li>
        <li className="nav-item d-none d-md-inline">
          <Link to="#" className="nav-link">
            {examTitle || translations[language].title}
          </Link>
        </li>
      </ul>
      <ul className="navbar-nav ml-auto">
        <li className="nav-item">
          <Link className="nav-link" to="#" role="button">
            <span id="timer">
              {translations[language].timer}: {timeRemaining}
            </span>
          </Link>
        </li>

        <li className="nav-item dropdown">
          <select
            className="form-control"
            value={language}
            onChange={handleLanguageChange}
            style={{ marginRight: "10px" }}
          >
            <option value="en">English</option>
            <option value="hi">हिंदी</option>
          </select>
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