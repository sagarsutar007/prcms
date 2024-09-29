import React from "react";
import DashboardFooter from "./DashboardFooter";
import DashboardNavbar from "./DashboardNavbar";
import DashboardSidebar from "./DashboardSidebar";
import { Card } from "react-bootstrap";

function Dashboard() {
	return (
		<div className="wrapper">
			<DashboardNavbar />
			<DashboardSidebar />
			<div className="content-wrapper">
				<section className="content">
					<div className="container-fluid">
						<div className="row">
							<div className="col-12 col-md-7">
								<Card className="mt-3">
									<Card.Body>
										<Card.Title className="h3">
											Welcome, Akhil Gupta!
										</Card.Title>
									</Card.Body>
								</Card>
							</div>
						</div>
					</div>
				</section>
			</div>
			<DashboardFooter />
		</div>
	);
}

export default Dashboard;
