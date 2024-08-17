import { Routes, Route } from "react-router-dom";
import Login from "./components/Login/Login";
import Register from "./components/Register/Register";
import PersonalDetail from "./components/Register/PersonalDetail";

function App() {
	return (
		<Routes>
			<Route path="/login" element={<Login />} />
			<Route path="/register" element={<Register />} />
			<Route path="/personal-detail" element={<PersonalDetail />} />
			{/* Add more routes as needed */}
		</Routes>
	);
}

export default App;
