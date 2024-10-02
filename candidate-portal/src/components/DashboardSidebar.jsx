import { Link } from "react-router-dom";

import brandLogo from "../assets/img/brand-logo-white.png";
import { useSelector } from "react-redux";


const DashboardSidebar = () => {
	const userDetails = useSelector((state) => state.auth.userDetails);
	const fullName = userDetails ? userDetails.fullName : "User";

	return (
		<aside className="main-sidebar sidebar-dark-primary elevation-4">
			<Link to="/student-Dashboard" className="brand-link">
				<img
					src={brandLogo}
					alt="Logo"
					className="brand-image img-circle elevation-3"
					style={{ opacity: 0.8 }}
				/>
				<span className="brand-text font-weight-light">Simrangroups</span>
			</Link>

			<div className="sidebar">
				<div className="user-panel mt-3 pb-3 mb-3 d-flex">
					<div className="image">
						<img
							src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg"
							className="img-circle elevation-2"
							alt="User Image"
						/>
					</div>
					<div className="info">
						<Link to="/my-profile" className="d-block">
							{fullName}
						</Link>
					</div>
				</div>
				<nav className="mt-2">
					<ul
						className="nav nav-pills nav-sidebar flex-column"
						data-widget="treeview"
						role="menu"
						data-accordion="false"
					>
						<li className="nav-item has-treeview menu-open">
							<Link to="/student-dashboard" className="nav-link active">
								<i className="nav-icon fas fa-tachometer-alt"></i>
								<p>Overview</p>
							</Link>
						</li>
						<li className="nav-item has-treeview menu-open">
							<Link to="/exams" className="nav-link">
								<i className="nav-icon fas fa-clipboard-check"></i>
								<p>Exams</p>
							</Link>
						</li>
						<li className="nav-item has-treeview menu-open">
							<Link to="/logout" className="nav-link">
								<i className="nav-icon fas fa-sign-out-alt"></i>
								<p>Logout</p>
							</Link>
						</li>
					</ul>
				</nav>
			</div>
		</aside>
	);
};

export default DashboardSidebar;
