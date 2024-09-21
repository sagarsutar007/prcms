import { Link } from "react-router-dom";
import { useDispatch, useSelector } from 'react-redux';
import { goToQuestion } from '../../features/exam/examSlice';
import brandLogo from "../../assets/img/brand-logo-white.png";

const ExamSidebar = () => {
    const dispatch = useDispatch();
    const questions = useSelector((state) => state.exam.questions);
    const currentIndex = useSelector((state) => state.exam.currentIndex);

    const handleQuestionClick = (index) => {
        dispatch(goToQuestion(index));
    };

    return (
        <aside className="main-sidebar sidebar-dark-primary elevation-4" style={{ minHeight: "100vh" }}>
            <Link to="/student-dashboard" className="brand-link">
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
                        <Link to="#" className="d-block">
                            Akhil Gupta
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
                        <li className="nav-header" style={{ backgroundColor: "inherit", color: "#d0d4db", fontSize: "12px" }}>
                            QUESTIONS
                        </li>
                        {/* List questions here */}
                        {questions && questions.length > 0 ? (
                            questions.map((question, index) => (
                                <li className={`nav-item ${currentIndex === index ? 'active' : ''}`} key={question.question_id}>
                                    <a
                                        href="#"
                                        className="nav-link"
                                        style={{ fontSize: "12px" }}
                                        onClick={() => handleQuestionClick(index)}
                                    >
                                        <p>{`${index + 1}. ${question.question_en}`}</p>
                                    </a>
                                </li>
                            ))
                        ) : (
                            <li className="nav-item">
                                <span className="nav-link" style={{ fontSize: "12px", color: "#d0d4db" }}>
                                    No questions available
                                </span>
                            </li>
                        )}
                    </ul>
                </nav>
            </div>
        </aside>
    );
};

export default ExamSidebar;

