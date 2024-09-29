import { Routes, Route, Navigate } from "react-router-dom";
import Login from "./components/Login/Login";
import Register from "./components/Register/Register";
import PersonalDetail from "./components/Register/PersonalDetail";
import OrganizationDetail from "./components/Register/OrganizationDetail";
import { useSelector } from "react-redux";
import Dashboard from "./components/Dashboard";
import Exams from "./components/Exams";
import Logout from "./components/Logout";
import ExamScreen from "./components/ExamScreen";

function App() {
	const isAuthenticated = useSelector((state) => state.auth.isAuthenticated);

	return (
		<Routes>
			<Route path="/login" element={<Login />} />
			<Route path="/register" element={<Register />} />
			<Route path="/personal-detail" element={<PersonalDetail />} />
			<Route path="/organisation-detail" element={<OrganizationDetail />} />

			{/* Protected Route */}
			<Route
				path="/student-dashboard"
				element={isAuthenticated ? <Dashboard /> : <Navigate to="/login" />}
			/>
			<Route
				path="/exams"
				element={isAuthenticated ? <Exams /> : <Navigate to="/login" />}
			/>
			<Route
				path="/exam/:examUrl"
				element={isAuthenticated ? <ExamScreen /> : <Navigate to="/login" />}
			/>

			<Route
				path="/logout"
				element={<Logout />}
			/>
			
		</Routes>
	);
}

export default App;
