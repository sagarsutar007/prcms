<div class="card card-primary card-outline card-outline-tabs">
  <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-personal-info-tab" data-toggle="pill" href="#custom-tabs-personal-info" role="tab" aria-controls="custom-tabs-personal-info" aria-selected="true">Personal</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-address-tab" data-toggle="pill" href="#custom-tabs-address" role="tab" aria-controls="custom-tabs-address" aria-selected="false">Address</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-bank-tab" data-toggle="pill" href="#custom-tabs-bank" role="tab" aria-controls="custom-tabs-bank" aria-selected="false">Bank</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-documents-tab" data-toggle="pill" href="#custom-tabs-documents" role="tab" aria-controls="custom-tabs-documents" aria-selected="false">Upload Documents</a>
      </li>
      <?php if (isset($record)) { ?>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-uploaded-documents-tab" data-toggle="pill" href="#custom-tabs-uploaded-documents" role="tab" aria-controls="custom-tabs-uploaded-documents" aria-selected="false">Uploaded Documents</a>
      </li>
      <?php } ?>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-four-tab-content">
      <div class="tab-pane fade show active" id="custom-tabs-personal-info">
        <div class="form-group mb-1">
          <label for="fstn">Candidate Name</label>
          <div class="row">
            <div class="col-md-4 mb-3">
              <input type="text" id="fstn" class="form-control" name="firstname" value="<?= $record['firstname']??set_value('firstname'); ?>" placeholder="First name*">
              <?= form_error('firstname', '<div class="text-danger">', '</div>'); ?>
            </div>
            <div class="col-md-4 mb-3">
              <input type="text" class="form-control" name="middlename" value="<?= $record['middlename']??set_value('middlename'); ?>" placeholder="Middle name">
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control" name="lastname" value="<?= $record['lastname']??set_value('lastname'); ?>" placeholder="Last name">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="cn">Phone Number</label>
              <input type="number" id="cn" class="form-control" name="phone" value="<?= $record['phone']??set_value('phone'); ?>" placeholder="9337xxxxxx">
              <?= form_error('phone', '<div class="text-danger">', '</div>'); ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="ce">Email Address</label>
              <input type="email" id="ce" class="form-control" name="email" value="<?= $record['email']??set_value('email'); ?>" placeholder="example@email.com">
              <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group mb-0">
              <label for="wn">WhatsApp Number</label>
              <input type="number" id="wn" class="form-control" name="whatsapp_number" value="<?= $record['whatsapp_number']??set_value('whatsapp_number'); ?>" placeholder="9337xxxxxx">
              <?= form_error('whatsapp_number', '<div class="text-danger">', '</div>'); ?>
              <input type="checkbox" id="same-wn"> <label style="font-weight: normal; font-size: 13px;" for="same-wn">Same as phone number</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="contact-person-picture">Passport Size Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="profile_img_file" class="custom-file-input" id="contact-person-picture">
                  <label class="custom-file-label" for="contact-person-picture">Choose file</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="bup">Candidate Password<sup>*</sup></label>
              <input type="password" id="bup" class="form-control" name="password" value="" placeholder="Enter password" maxlength="12">
              <?= form_error('password', '<div class="text-danger">', '</div>'); ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="gender">Gender</label>
              <select name="gender" class="form-control" id="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="Other">Transgender</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="fn">Father's Name</label>
              <input type="text" id="fn" class="form-control" name="father_name" value="<?= $record['father_name']??set_value('father_name'); ?>" placeholder="Enter Fathers Name">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="ms">Marital Status</label>
              <select id="ms" class="form-control" name="marital_status">
                <?php
                  if(isset($record['marital_status'])){
                    echo "<option value='". $record['marital_status'] ."' hidden selected>".ucfirst(strtolower($record['marital_status']))."</option>";
                  }
                ?>
                <option value="married">Married</option>
                <option value="un-married">Un-married</option>
                <option value="divorced">Divorced</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="dob">Date of Birth</label>
              <input type="text" id="dob" class="form-control" name="dob" value="<?= isset($record['dob'])?date('d-m-Y', strtotime($record['dob'])):set_value('dob'); ?>" placeholder="Enter Date">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="empid">Employee ID</label>
              <input type="text" id="empid" class="form-control" name="empid" value="<?= isset($record['empid'])?date('d-m-Y', strtotime($record['empid'])):set_value('empid'); ?>" placeholder="Enter Employee Id">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="highest_qualification">Highest Qualification</label>
              <select class="form-control" name="highest_qualification" id="highest_qualification">
                <?php if (isset($record['highest_qualification']) && !empty($record['highest_qualification'])) { ?>
                <option value="<?= $record['highest_qualification']; ?>" selected><?= $record['highest_qualification']; ?></option>
                <?php } ?>
                <option value="" hidden>Select qualification</option>
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
                <option value="Diploma">Diploma</option>
                <option value="Graduation">Graduation</option>
              </select>
            </div>
          </div>
          <!-- <div class="col-md-4">
            <div class="form-group">
              <label for="passout_year">Year</label>
              <input type="number" minlength="4" maxlength="4" id="passout_year" class="form-control" name="passout_year" value="<?= $record['passout_year']??set_value('passout_year'); ?>" placeholder="Enter year">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="per-sec">% Secured</label>
              <input type="text" id="per-sec" class="form-control" name="percentage_secured" value="<?= $record['percentage_secured']??set_value('percentage_secured'); ?>" placeholder="Enter % secured">
            </div>
          </div> -->
        <!-- </div>
        <div class="row"> -->
          <div class="col-md-4">
            <div class="form-group">
              <label for="aadn">Aadhaar Number</label>
              <input type="number" id="aadn" class="form-control" name="aadhaar_number" value="<?= $record['aadhaar_number']??set_value('aadhaar_number'); ?>" placeholder="Enter 12 digit Aadhaar number">
              <?= form_error('aadhaar_number', '<div class="text-danger">', '</div>'); ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="com">Company</label>
              <select name="company_id" class="form-control" id="com">
                <?php 
                  foreach ($companies as $key => $obj) { 
                    if (isset($record) && $obj['id'] == $record['company_id']) {
                ?>
                <option value="<?= $obj['id']; ?>" selected><?= $obj['company_name']; ?></option>
                <?php } else { ?>
                <option value="<?= $obj['id']; ?>"><?= $obj['company_name']; ?></option>
                <?php }  } ?>
              </select>
            </div>
          </div>
          <?php if (isset($record)) { ?>
          <div class="col-md-4">
            <div class="form-group">
              <label>Status</label>
              <div class="d-flex align-items-center">
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" id="status-active" name="status" value="active" <?= (isset($record)&&$record['status']=='active')?'checked':''; ?>>
                  <label for="status-active" class="custom-control-label fw-4">Active</label>
                </div>
                <div class="custom-control custom-radio ml-4">
                  <input class="custom-control-input" type="radio" id="status-blocked" name="status" value="blocked" <?= (isset($record)&&$record['status']=='blocked')?'checked':''; ?>>
                  <label for="status-blocked" class="custom-control-label fw-4">Blocked</label>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="tab-pane fade" id="custom-tabs-address">
        <div class="row">
          <div class="col-md-12">
            <h5>Present Address</h5>
            <hr>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="adl1">Address</label>
              <input type="text" id="adl1" class="form-control" name="ca_address" value="<?= $record['ca_address']??set_value('ca_address'); ?>" placeholder="Enter address lane 1">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="adl2">Address Landmark</label>
              <input type="text" id="adl2" class="form-control" name="ca_address_landmark" value="<?= $record['ca_address_landmark']??set_value('ca_address_landmark'); ?>" placeholder="Enter address lane 2">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ca_city">City</label>
              <input type="text" id="ca_city" class="form-control" name="ca_city" value="<?= $record['ca_city']??set_value('ca_city'); ?>" placeholder="Enter city">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ca_dist">District</label>
              <input type="text" id="ca_dist" class="form-control" name="ca_dist" value="<?= $record['ca_dist']??set_value('ca_dist'); ?>" placeholder="Enter district">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ca_state">State</label>
              <select class="form-control" name="ca_state">
                <optgroup label="States">
                  <option value="Andhra Pradesh">Andhra Pradesh</option>
                  <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                  <option value="Assam">Assam</option>
                  <option value="Bihar">Bihar</option>
                  <option value="Chhattisgarh">Chhattisgarh</option>
                  <option value="Goa">Goa</option>
                  <option value="Gujarat">Gujarat</option>
                  <option value="Haryana">Haryana</option>
                  <option value="Himachal Pradesh">Himachal Pradesh</option>
                  <option value="Jharkhand">Jharkhand</option>
                  <option value="Karnataka">Karnataka</option>
                  <option value="Kerala">Kerala</option>
                  <option value="Madhya Pradesh">Madhya Pradesh</option>
                  <option value="Maharashtra">Maharashtra</option>
                  <option value="Manipur">Manipur</option>
                  <option value="Meghalaya">Meghalaya</option>
                  <option value="Mizoram">Mizoram</option>
                  <option value="Nagaland">Nagaland</option>
                  <option value="Odisha">Odisha</option>
                  <option value="Punjab">Punjab</option>
                  <option value="Rajasthan">Rajasthan</option>
                  <option value="Sikkim">Sikkim</option>
                  <option value="Tamil Nadu">Tamil Nadu</option>
                  <option value="Telangana">Telangana</option>
                  <option value="Tripura">Tripura</option>
                  <option value="Uttar Pradesh">Uttar Pradesh</option>
                  <option value="Uttarakhand">Uttarakhand</option>
                  <option value="West Bengal">West Bengal</option>
                </optgroup>
                <optgroup label="Union Territories">
                  <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                  <option value="Chandigarh">Chandigarh</option>
                  <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                  <option value="Lakshadweep">Lakshadweep</option>
                  <option value="Delhi">Delhi</option>
                  <option value="Puducherry">Puducherry</option>
                </optgroup>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ca_pin">Pincode</label>
              <input type="text" id="ca_pin" class="form-control" name="ca_pin" value="<?= $record['ca_pin']??set_value('ca_pin'); ?>" placeholder="Enter Pincode" maxlength="6">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h5>Permanent Address</h5>
            <hr>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pa_adl1">Address</label>
              <input type="text" id="pa_adl1" class="form-control" name="pa_address" value="<?= $record['pa_address']??set_value('pa_address'); ?>" placeholder="Enter address lane 1">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pa_adl2">Address Landmark</label>
              <input type="text" id="pa_adl2" class="form-control" name="pa_address_landmark" value="<?= $record['pa_address_landmark']??set_value('pa_address_landmark'); ?>" placeholder="Enter address lane 2">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pa_city">City</label>
              <input type="text" id="pa_city" class="form-control" name="pa_city" value="<?= $record['pa_city']??set_value('pa_city'); ?>" placeholder="Enter city">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pa_dist">District</label>
              <input type="text" id="pa_dist" class="form-control" name="pa_dist" value="<?= $record['pa_dist']??set_value('pa_dist'); ?>" placeholder="Enter district">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pa_state">State</label>
              <select class="form-control" name="pa_state" id="pa_state">
                <optgroup label="States">
                  <option value="Andhra Pradesh">Andhra Pradesh</option>
                  <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                  <option value="Assam">Assam</option>
                  <option value="Bihar">Bihar</option>
                  <option value="Chhattisgarh">Chhattisgarh</option>
                  <option value="Goa">Goa</option>
                  <option value="Gujarat">Gujarat</option>
                  <option value="Haryana">Haryana</option>
                  <option value="Himachal Pradesh">Himachal Pradesh</option>
                  <option value="Jharkhand">Jharkhand</option>
                  <option value="Karnataka">Karnataka</option>
                  <option value="Kerala">Kerala</option>
                  <option value="Madhya Pradesh">Madhya Pradesh</option>
                  <option value="Maharashtra">Maharashtra</option>
                  <option value="Manipur">Manipur</option>
                  <option value="Meghalaya">Meghalaya</option>
                  <option value="Mizoram">Mizoram</option>
                  <option value="Nagaland">Nagaland</option>
                  <option value="Odisha">Odisha</option>
                  <option value="Punjab">Punjab</option>
                  <option value="Rajasthan">Rajasthan</option>
                  <option value="Sikkim">Sikkim</option>
                  <option value="Tamil Nadu">Tamil Nadu</option>
                  <option value="Telangana">Telangana</option>
                  <option value="Tripura">Tripura</option>
                  <option value="Uttar Pradesh">Uttar Pradesh</option>
                  <option value="Uttarakhand">Uttarakhand</option>
                  <option value="West Bengal">West Bengal</option>
                </optgroup>
                <optgroup label="Union Territories">
                  <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                  <option value="Chandigarh">Chandigarh</option>
                  <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                  <option value="Lakshadweep">Lakshadweep</option>
                  <option value="Delhi">Delhi</option>
                  <option value="Puducherry">Puducherry</option>
                </optgroup>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pa_pin">Pincode</label>
              <input type="text" id="pa_pin" class="form-control" name="pa_pin" value="<?= $record['pa_pin']??set_value('pa_pin'); ?>" placeholder="Enter Pincode" maxlength="6">
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="custom-tabs-bank">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="bn">Bank Name</label>
              <input type="text" id="bn" class="form-control" name="bank_name" value="<?= $record['bank_name']??set_value('bank_name'); ?>" placeholder="Enter Bank Name">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="acn">Account Number</label>
              <input type="text" id="acn" class="form-control" name="account_num" value="<?= $record['account_num']??set_value('account_num'); ?>" placeholder="Enter Account Number">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="ifsc">IFSC Code</label>
              <input type="text" id="ifsc" class="form-control" name="ifsc_code" value="<?= $record['ifsc_code']??set_value('ifsc_code'); ?>" placeholder="Enter IFSC Code">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="pancard-picture">Passbook Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="passbook_pic" class="custom-file-input" id="passbook_pic">
                  <label class="custom-file-label" for="passbook_pic">Choose file</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pancard-picture">Chequebook Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="chequebook_pic" class="custom-file-input" id="chequebook_pic">
                  <label class="custom-file-label" for="chequebook_pic">Choose file</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="custom-tabs-documents">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="passport-picture">Upload Aadhaar Card Front Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="aadhaar_card_front_pic" class="custom-file-input" id="aadhaar_card_front_pic">
                  <label class="custom-file-label" for="aadhaar_card_front_pic">Choose Aadhaar Card Front Photo</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pancard-picture">Upload Aadhaar Card Back Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="aadhaar_card_back_pic" class="custom-file-input" id="aadhaar_card_back_pic">
                  <label class="custom-file-label" for="aadhaar_card_back_pic">Choose Aadhaar Card Back Photo</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="passport-picture">Upload Voter ID Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="voter_id" class="custom-file-input" id="voter-id">
                  <label class="custom-file-label" for="voter-id">Choose Voter ID Photo</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="pancard-picture">Upload Pancard Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="pancard_pic" class="custom-file-input" id="pancard-picture">
                  <label class="custom-file-label" for="pancard-picture">Choose Pancard Photo</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="education-proof">Upload Education Proof</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="education_proof" class="custom-file-input" id="education-proof">
                  <label class="custom-file-label" for="education-proof">Choose Education Certificate Photo</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="signature">Upload Signature Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="signature" class="custom-file-input" id="signature">
                  <label class="custom-file-label" for="signature">Choose Candidate Signature Photo</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if (isset($record)) { ?>
      <div class="tab-pane fade" id="custom-tabs-uploaded-documents">
        <table class="table table-striped">
          <?php if (!empty($record['profile_img']) && file_exists('./assets/img/'.$record['profile_img'])) { ?>            
          <tr>
            <td width="15%">
              <img src="<?= base_url('./assets/img/'.$record['profile_img']); ?>" width="50px" alt="">
            </td>
            <td>Profile Image</td>
            <td width="25%">
              <a href="<?= base_url('./assets/img/'.$record['profile_img']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
              <button data-asset="profile_img" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
          <?php } ?>
          <?php if (!empty($record['passbook_pic']) && file_exists('./assets/img/'.$record['passbook_pic'])) { ?>
          <tr>
            <td width="15%">
              <img src="<?= base_url('./assets/img/'.$record['passbook_pic']); ?>" width="50px" alt="">
            </td>
            <td>Passbook Image</td>
            <td width="25%">
              <a href="<?= base_url('./assets/img/'.$record['passbook_pic']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
              <button data-asset="passbook_pic" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
          <?php } ?>
          <?php if (!empty($record['chequebook_pic']) && file_exists('./assets/img/'.$record['chequebook_pic'])) { ?>
          <tr>
            <td width="15%">
              <img src="<?= base_url('./assets/img/'.$record['chequebook_pic']); ?>" width="50px" alt="">
            </td>
            <td>Chequebook Image</td>
            <td width="25%">
              <a href="<?= base_url('./assets/img/'.$record['chequebook_pic']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
              <button data-asset="chequebook_pic" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
          <?php } ?>
          <?php if (!empty($record['aadhaar_card_front_pic']) && file_exists('./assets/img/'.$record['aadhaar_card_front_pic'])) { ?>
          <tr>
            <td width="15%">
              <img src="<?= base_url('./assets/img/'.$record['aadhaar_card_front_pic']); ?>" width="50px" alt="">
            </td>
            <td>Aadhaar Front Image</td>
            <td width="25%">
              <a href="<?= base_url('./assets/img/'.$record['aadhaar_card_front_pic']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
              <button data-asset="aadhaar_card_front_pic" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
          <?php } ?>
          <?php if (!empty($record['aadhaar_card_back_pic']) && file_exists('./assets/img/'.$record['aadhaar_card_back_pic'])) { ?>
          <tr>
            <td width="15%">
              <img src="<?= base_url('./assets/img/'.$record['aadhaar_card_back_pic']); ?>" width="50px" alt="">
            </td>
            <td>Aadhaar Back Image</td>
            <td width="25%">
              <a href="<?= base_url('./assets/img/'.$record['aadhaar_card_back_pic']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
              <button data-asset="aadhaar_card_back_pic" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
          <?php } ?>
          <?php if (!empty($record['voter_id']) && file_exists('./assets/img/'.$record['voter_id'])) { ?>
          <tr>
            <td width="15%">
              <img src="<?= base_url('./assets/img/'.$record['voter_id']); ?>" width="50px" alt="">
            </td>
            <td>Voter ID Card Image</td>
            <td width="25%">
              <a href="<?= base_url('./assets/img/'.$record['voter_id']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
              <button data-asset="voter_id" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
          <?php } ?>
          <?php if (!empty($record['pancard_pic']) && file_exists('./assets/img/'.$record['pancard_pic'])) { ?>
          <tr>
            <td width="15%">
              <img src="<?= base_url('./assets/img/'.$record['pancard_pic']); ?>" width="50px" alt="">
            </td>
            <td>Pancard Image</td>
            <td width="25%">
              <a href="<?= base_url('./assets/img/'.$record['pancard_pic']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
              <button data-asset="pancard_pic" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
          <?php } ?>
        </table>
      </div>
      <?php } ?>
      <?php if (!empty($record['education_proof']) && file_exists('./assets/img/'.$record['education_proof'])) { ?>
      <tr>
        <td width="15%">
          <img src="<?= base_url('./assets/img/'.$record['education_proof']); ?>" width="50px" alt="">
        </td>
        <td>Education Certificate</td>
        <td width="15%">
          <a href="<?= base_url('./assets/img/'.$record['education_proof']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
          <button data-asset="education_proof" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
      <?php } ?>
      <?php if (!empty($record['signature']) && file_exists('./assets/img/'.$record['signature'])) { ?>
      <tr>
        <td width="15%">
          <img src="<?= base_url('./assets/img/'.$record['signature']); ?>" width="50px" alt="">
        </td>
        <td>Signature Photo</td>
        <td width="15%">
          <a href="<?= base_url('./assets/img/'.$record['signature']); ?>" target="_blank" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a> / 
          <button data-asset="signature" type="button" class="btn btn-link btn-remove-asset" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
      <?php } ?>
    </div>
  </div>
  <div class="card-footer text-right">
    <button type="button" id="btn-update-candidate" class="btn btn-primary ">
      <i class="fas fa-check"></i> SUBMIT
    </button>
  </div>
</div>