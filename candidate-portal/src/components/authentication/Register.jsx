import React from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faBuilding, faBinoculars, faStar, faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import './Register.css';

function Register() {
  const [showPassword, setShowPassword] = React.useState(false);

  const handlePasswordToggle = (field) => {
    setShowPassword((prevState) => ({
      ...prevState,
      [field]: !prevState[field],
    }));
  };

  return (
    <div className="wrapper">
      <div className="container-fluid">
        <div className="row">
          {/* Features Section */}
          <div className="col-md-6 bg-darkblue text-white d-none d-md-flex flex-column justify-content-center p-5">
            <h3>Activate Your <span className="text-orange">Success!</span></h3>
            <p className="text-sm">Signup with us and set up your profile to unlock new possibilities.</p>
            <div className="my-4">
              <div className="d-flex align-items-center mb-2">
                <FontAwesomeIcon icon={faBuilding} style={{ marginRight: '12px' }} className="text-orange" /> Reach top employers
              </div>
              <div className="d-flex align-items-center mb-2">
                <FontAwesomeIcon icon={faBinoculars} style={{ marginRight: '12px' }} className="text-orange" /> Get selected effortlessly
              </div>
              <div className="d-flex align-items-center mb-2">
                <FontAwesomeIcon icon={faStar} style={{ marginRight: '12px' }} className="text-orange" /> It's free and always will be
              </div>
            </div>
          </div>
          {/* Signup Form Section */}
          <div className="col-md-6 bg-white px-4 py-5">
            <h5 className="text-center">Get Started!</h5>
            <p className="text-center text-secondary text-sm">Use your information to create a profile</p>
            <form>
              <div className="row">
                <div className="col-md-6 mb-3"> 
                  <div className="form-group">
                    <input type="text" name="firstname" id="firstname" className="form-control" placeholder="First name" />
                  </div>
                </div>
                <div className="col-md-6 mb-3"> 
                  <div className="form-group">
                    <input type="text" name="lastname" id="lastname" className="form-control" placeholder="Last name" />
                  </div>
                </div>
              </div>
              
              <div className="row">
                <div className="col-md-6 mb-3"> 
                  <div className="form-group">
                    <input type="email" name="email" id="email" className="form-control" placeholder="Email address" />
                  </div>
                </div>
                <div className="col-md-6 mb-3"> 
                  <div className="form-group">
                    <input type="text" name="phone" id="phone" className="form-control" placeholder="Phone" />
                    <div className="form-check mt-2"> {/* Added margin-top */}
                      <input type="checkbox" name="same_wa_num" value="1" id="samewanum" className="form-check-input" />
                      <label htmlFor="samewanum" className="form-check-label text-sm">Same as my WhatsApp number</label>
                    </div>
                  </div>
                </div>
              </div>
              
              <div className="row">
                <div className="col-md-6 mb-3"> 
                  <div className="form-group">
                    <select name="highest_qualification" className="custom-select d-block w-100">
                      <option value="" hidden>Select Qualification</option>
                      <option value="10th Pass">10th Pass</option>
                      <option value="12th pass">12th pass</option>
                      <option value="10th + ITI">10th + ITI</option>
                      <option value="12+ ITI">12+ ITI</option>
                      <option value="B.A">B.A</option>
                      <option value="B.COM">B.COM</option>
                      <option value="BBA">BBA</option>
                      <option value="BCA">BCA</option>
                      <option value="B.SC">B.SC</option>
                      <option value="B.TECH">B.TECH</option>
                      <option value="MBA">MBA</option>
                      <option value="MCA">MCA</option>
                      <option value="M.A">M.A</option>
                      <option value="M.COM">M.COM</option>
                      <option value="Any Graduation">Any Graduation</option>
                      <option value="Diploma">Diploma</option>
                    </select>
                  </div>
                </div>
                <div className="col-md-6 mb-3"> 
                  <div className="form-group">
                    <select name="company_id" className="custom-select d-block w-100">
                      <option value="" hidden>Select Business Unit</option>
                      <option value="2">Kamal Enterprises</option>
                      <option value="1">B.S Enterprises</option>
                      <option value="6">Simran Enterprises</option>
                    </select>
                  </div>
                </div>
                <div className="col-md-4 mb-3"> 
                  <div className="form-group">
                    <select name="gender" id="gender" className="custom-select d-block w-100">
                      <option value="" hidden>Select Gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="transgender">Transgender</option>
                    </select>
                  </div>
                </div>
                <div className="col-md-8 mb-3">
                <div className="form-group">
                  <input
                    type="file"
                    className="form-control"
                    id="fileInput"
                  />
                </div>
                </div>
                <div className="col-md-6 mb-3"> 
                  <div className="form-group">
                    <input name="dob" id="datepicker" className="form-control" type="text" placeholder="Date of Birth" />
                  </div>
                </div>
                <div className="col-md-6 mb-3"> 
                  <div className="form-group">
                    <input name="empid" id="empid" className="form-control" type="text" placeholder="Employee Id" />
                  </div>
                </div>
                <div className="col-md-6 mb-3">
                  <div className="form-group">
                    <div className="input-group">
                      <input
                        type={showPassword.password ? 'text' : 'password'}
                        id="password"
                        className="form-control"
                        name="password"
                        placeholder="Enter password"
                      />
                      <div className="input-group-append">
                        <span
                          className="input-group-text toggle-password"
                          onClick={() => handlePasswordToggle('password')}
                        >
                          <FontAwesomeIcon icon={showPassword.password ? faEye : faEyeSlash} />
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="col-md-6 mb-3">
                  <div className="form-group">
                    <div className="input-group">
                      <input
                        type={showPassword.passconf ? 'text' : 'password'}
                        id="passconf"
                        className="form-control"
                        name="passconf"
                        placeholder="Confirm password"
                      />
                      <div className="input-group-append">
                        <span
                          className="input-group-text toggle-confirm-password"
                          onClick={() => handlePasswordToggle('passconf')}
                        >
                          <FontAwesomeIcon icon={showPassword.passconf ? faEye : faEyeSlash} />
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="col-md-12 mb-3">
                  <div className="d-flex justify-content-end">
                    <button className="btn btn-primary">Register Me</button>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  );
}

export default Register;
