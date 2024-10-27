import { NavLink } from "react-router-dom";
import brandLogo from "../assets/img/brand-logo-white.png";
import { useSelector } from "react-redux";

const DashboardSidebar = () => {
  const userDetails = useSelector((state) => state.auth.userDetails);
  const fullName = userDetails ? userDetails.fullName : "User";

  return (
    <aside className="main-sidebar sidebar-dark-primary elevation-4">
      <NavLink to="/student-dashboard" className="brand-link">
        <img
          src={brandLogo}
          alt="Logo"
          className="brand-image img-circle elevation-3"
          style={{ opacity: 0.8 }}
        />
        <span className="brand-text font-weight-light">Simrangroups</span>
      </NavLink>

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
            <NavLink to="/my-profile" className="d-block">
              {fullName}
            </NavLink>
          </div>
        </div>
        <nav className="mt-2">
          <ul
            className="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false"
          >
            <li className="nav-item">
              <NavLink
                to="/student-dashboard"
                className={({ isActive }) =>
                  `nav-link ${isActive ? "active" : ""}`
                }
				data-widget="pushmenu"
              >
                <i className="nav-icon fas fa-tachometer-alt"></i>
                <p>Overview</p>
              </NavLink>
            </li>
            <li className="nav-item">
              <NavLink
                to="/exams"
                className={({ isActive }) =>
                  `nav-link ${isActive ? "active" : ""}`
                }
				data-widget="pushmenu"
              >
                <i className="nav-icon fas fa-clipboard-check"></i>
                <p>Exams</p>
              </NavLink>
            </li>
            <li className="nav-item">
              <NavLink
                to="/logout"
                className={({ isActive }) =>
                  `nav-link ${isActive ? "active" : ""}`
                }
              >
                <i className="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
              </NavLink>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
  );
};

export default DashboardSidebar;
