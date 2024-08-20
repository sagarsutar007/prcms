import { Routes, Route } from "react-router-dom";
import Login from "./components/Login/Login";
import Register from "./components/Register/Register";
import PersonalDetail from "./components/Register/PersonalDetail";
import OrganizationDetail from "./components/Register/OrganizationDetail";

function App() {
	return (
		<Routes>
			<Route path="/login" element={<Login />} />
			<Route path="/register" element={<Register />} />
			<Route path="/personal-detail" element={<PersonalDetail />} />
			<Route path="/organisation-detail" element={<OrganizationDetail />} />
			{/* Add more routes as needed */}
		</Routes>
	);
}

export default App;
