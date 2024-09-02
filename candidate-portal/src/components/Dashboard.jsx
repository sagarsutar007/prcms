import React from "react";
import DashboardFooter from "./DashboardFooter";
import DashboardNavbar from "./DashboardNavbar";
import DashboardSidebar from "./DashboardSidebar";

function Dashboard() {
	return (
		<div className="wrapper">
			<DashboardNavbar />
			<DashboardSidebar />
			<div className="content-wrapper">
				<section className="content">
					<div className="container-fluid">{/* Your main content here */}</div>
				</section>
			</div>
			<DashboardFooter />
		</div>
	);
}

export default Dashboard;
