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
import ProtectedExamRoute from "./ProtectedExamRoute";
import './app.css';

function App() {
	const isAuthenticated = useSelector((state) => state.auth.isAuthenticated);

	return (
		<Routes>
			<Route
				path="/"
				element={isAuthenticated ? <Navigate to="/student-dashboard" /> : <Navigate to="/login" />}
			/>
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
				element={<ProtectedExamRoute />}
			/>

			<Route
				path="/logout"
				element={<Logout />}
			/>

		</Routes>
	);
}

export default App;
