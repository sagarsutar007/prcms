import { Routes, Route, Navigate } from "react-router-dom";
import Login from "./components/Login/Login";
import Register from "./components/Register/Register";
import PersonalDetail from "./components/Register/PersonalDetail";
import OrganizationDetail from "./components/Register/OrganizationDetail";
import { useSelector } from "react-redux";

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
				element={isAuthenticated ? <Register /> : <Navigate to="/login" />}
			/>

			{/* Add other routes here if needed */}
		</Routes>
	);
}

export default App;
