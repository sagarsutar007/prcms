import { useEffect } from "react";
import { Link } from "react-router-dom";

const ExamNavbar = ({ examTitle }) => {
    useEffect(() => {
        document.body.classList.add("sidebar-collapse");
        
        return () => {
            document.body.classList.remove("sidebar-collapse");
        };
    }, []);
	return (
		<nav className="main-header navbar navbar-expand navbar-white navbar-light">
			<ul className="navbar-nav">
				<li className="nav-item">
					<a className="nav-link" data-widget="pushmenu" href="#" role="button">
						<i className="fas fa-bars"></i>
					</a>
                </li>
                <li className="nav-item d-none d-sm-inline-block">
                    <Link to="#" className="nav-link">{ examTitle }</Link>
                </li>
            </ul>
            <ul className="navbar-nav ml-auto">
                <li className="nav-item">
                    <Link className="nav-link" to="#" role="button">
                        <span id="timer"></span>
                    </Link>
                </li>
                <li className="nav-item">
                    <Link className="nav-link" data-widget="fullscreen" to="#" role="button">
                        <i className="fas fa-expand-arrows-alt"></i>
                    </Link>
                </li>
            </ul>
		</nav>
	);
};

export default ExamNavbar;