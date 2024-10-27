import { useParams, Navigate } from "react-router-dom";
import { useSelector } from "react-redux";
import ExamScreen from "./components/ExamScreen";

function ProtectedExamRoute() {
    const isAuthenticated = useSelector((state) => state.auth.isAuthenticated);
    const { examUrl } = useParams();

    return isAuthenticated ? (
        <ExamScreen />
    ) : (
        <Navigate to="/login" state={{ from: `/exam/${examUrl}` }} />
    );
}

export default ProtectedExamRoute;
