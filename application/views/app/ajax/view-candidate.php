<style>
  #sub-section .nav-pills .nav-link {
    border-radius: 0px;
  }
  #sub-section .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #007bff;
    background-color: transparent;
    border-bottom: 3px solid #007bff;
  }
</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body box-profile">
          <div class="row">
            <div class="col-md-2">
              <?php if (!empty($record['profile_img']) && file_exists('./assets/img/'.$record['profile_img'])) { ?>
              <div class="box-profile">
                <img class="profile-user-img img-circle" height="100px" src="<?= base_url('./assets/img/'.$record['profile_img']); ?>" alt="">
              </div>
              <?php } else { ?>
              <div class="box-profile">
                <img class="profile-user-img img-circle" height="100px" src="<?= base_url('./assets/img/letter-p.png'); ?>" alt="">
              </div>
              <?php } ?>
            </div>
            <div class="col-md-10">
              <h3 class="profile-username mb-0">
                <strong><?= $record['firstname'] . " " . $record['middlename']  . " " .  $record['lastname']; ?></strong>
              </h3>
              <div class="text-muted text-sm text-justify">
                <?= (!empty($record['gender']))?ucfirst($record['gender']):'unknown'; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header p-0 px-3" id="sub-section">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link active" href="#profile" data-toggle="tab">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#address" data-toggle="tab">Address</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#bank" data-toggle="tab">Bank Info</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#docs" data-toggle="tab">Documents</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#sms" data-toggle="tab">SMS Reports</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#emails" data-toggle="tab">Email Reports</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="card">
        <div class="card-body p-0">
          <div class="tab-content">
            <div class="active tab-pane p-3" id="profile">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Name</div>
                    <h5><?= $record['firstname'] . " " . $record['middlename'] . " " . $record['lastname']; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Gender</div>
                    <h5><?= $record['gender']?ucfirst($record['gender']):'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Phone</div>
                    <h5><?= $record['phone']??'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Email</div>
                    <h5><?= $record['email']??'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Date of Birth</div>
                    <h5><?php if(!empty($record['dob'])){ echo date('d-m-Y', strtotime($record['dob'])); }; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">WhatsApp Number</div>
                    <h5><?= $record['whatsapp_number']; ?></h5>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Marital Status</div>
                    <h5><?= !empty($record['marital_status'])?ucfirst($record['marital_status']):''; ?></h5>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Father's Name</div>
                    <h5><?= $record['father_name']; ?></h5>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Highest Qualification</div>
                    <h5><?= $record['highest_qualification']; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Employee ID</div>
                    <h5><?= $record['empid']; ?></h5>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Aadhaar Card Number</div>
                    <h5><?= $record['aadhaar_number']; ?></h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane p-3" id="address">
              <div class="row">
                <div class="col-md-12">
                  <h5>Permanent Address</h5>
                  <hr>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Address</div>
                    <h5><?= (!empty($record['pa_address']))?$record['pa_address']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Landmark</div>
                    <h5><?= (!empty($record['pa_address_landmark']))?$record['pa_address_landmark']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">City</div>
                    <h5><?= (!empty($record['pa_city']))?$record['pa_city']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">District</div>
                    <h5><?= (!empty($record['pa_dist']))?$record['pa_dist']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">State</div>
                    <h5><?= (!empty($record['pa_state']))?$record['pa_state']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Pincode</div>
                    <h5><?= (!empty($record['pa_pin']))?$record['pa_pin']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-12">
                  <br>
                  <h5>Current Address</h5>
                  <hr>
                </div>
                <hr>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Address</div>
                    <h5><?= (!empty($record['ca_address']))?$record['ca_address']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Landmark</div>
                    <h5><?= (!empty($record['ca_address_landmark']))?$record['ca_address_landmark']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">City</div>
                    <h5><?= (!empty($record['ca_city']))?$record['ca_city']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">District</div>
                    <h5><?= (!empty($record['ca_dist']))?$record['ca_dist']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">State</div>
                    <h5><?= (!empty($record['ca_state']))?$record['ca_state']:'Not Available'; ?></h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Pincode</div>
                    <h5><?= (!empty($record['ca_pin']))?$record['ca_pin']:'Not Available'; ?></h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane p-3" id="bank">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Bank Name</div>
                    <h5><?= $record['bank_name']; ?></h5>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="text-secondary text-sm">Account Number</div>
                    <h5><?= $record['account_num']; ?></h5>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div class="text-secondary text-sm">IFSC Code</div>
                    <h5><?= $record['ifsc_code']; ?></h5>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Passbook</label>
                    <br>
                    <?php if ( !empty($record['passbook_pic']) && file_exists('./assets/img/'.$record['passbook_pic'])) { ?>
                      <a href="<?= base_url('assets/img/'.$record['passbook_pic']); ?>" target="_blank">
                        <img src="<?= base_url('assets/img/'.$record['passbook_pic']); ?>" class="rounded img-thumbnail" style="max-width: 150px;" alt="Passbook Picture"><br>
                      </a>
                    <?php } else { ?>
                      <h5><a href="#">Not uploaded</a></h5>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Cheque Book</label>
                    <br>
                    <?php if ( !empty($record['chequebook_pic']) && file_exists('./assets/img/'.$record['chequebook_pic'])) { ?>
                      <a href="<?= base_url('assets/img/'.$record['chequebook_pic']); ?>" target="_blank"><img src="<?= base_url('assets/img/'.$record['chequebook_pic']); ?>" class="rounded img-thumbnail" style="max-width: 150px;" alt="Chequebook Picture">
                      </a>
                    <?php } else { ?>
                      <h5><a href="#">Not uploaded</a></h5>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane p-3" id="docs">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <div>Aadhaar Front</div>
                    <?php if (!empty($record['aadhaar_card_front_pic']) && file_exists('./assets/img/'.$record['aadhaar_card_front_pic'])) { ?>
                      <a href="<?= base_url('assets/img/'.$record['aadhaar_card_front_pic']); ?>" target="_blank">
                        <img src="<?= base_url('assets/img/'.$record['aadhaar_card_front_pic']); ?>" class="rounded img-thumbnail" style="max-width: 150px;" alt="Aadhaar Picture">
                      </a>
                    <?php } else { ?>
                      <h5><a href="#">Not uploaded</a></h5>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div>Aadhaar Back</div>
                    <?php if (!empty($record['aadhaar_card_back_pic']) && file_exists('./assets/img/'.$record['aadhaar_card_back_pic'])) { ?>
                      <a href="<?= base_url('assets/img/'.$record['aadhaar_card_back_pic']); ?>" target="_blank">
                        <img src="<?= base_url('assets/img/'.$record['aadhaar_card_back_pic']); ?>" class="rounded img-thumbnail" style="max-width: 150px;" alt="Aadhaar Picture">
                      </a>
                    <?php } else { ?>
                      <h5><a href="#">Not uploaded</a></h5>
                    <?php } ?>
                  </div>
                </div>  
                <div class="col-md-3">
                  <div class="form-group">
                    <div>Pancard</div>
                    <?php if (!empty($record['pancard_pic']) && file_exists('./assets/img/'.$record['pancard_pic'])) { ?>
                      <a href="<?= base_url('assets/img/'.$record['pancard_pic']); ?>" target="_blank">
                        <img src="<?= base_url('assets/img/'.$record['pancard_pic']); ?>" class="rounded img-thumbnail" style="max-width: 150px;" alt="Pancard Picture">
                      </a>
                    <?php } else { ?>
                      <h5><a href="#">Not uploaded</a></h5>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div>Voter ID</div>
                    <?php if ( !empty($record['voter_id']) && file_exists('./assets/img/'.$record['voter_id'])) { ?>
                      <a href="<?= base_url('assets/img/'.$record['voter_id']); ?>" target="_blank">
                        <img src="<?= base_url('assets/img/'.$record['voter_id']); ?>" class="rounded img-thumbnail" style="max-width: 150px;" alt="Voter Picture">
                      </a>
                    <?php } else { ?>
                      <h5><a href="#">Not uploaded</a></h5>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane p-2" id="sms">
              <table id="sms-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>SNo.</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Delivery</th>
                    <th>Response</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach ($sms_records as $sms_recs => $sms_rec) { ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td>
                      <?= date('d-m-Y h:ia', strtotime($sms_rec['created_on'])); ?>
                    </td>
                    <td>
                      <?= $sms_rec['notif_type']; ?>
                    </td>
                    <td>
                        <?= $sms_rec['response']; ?>
                    </td>
                    <td>
                        <?= $email_rec['req_response']; ?>
                    </td>
                  </tr>
                  <?php $i++; } ?>
                </tbody>
              </table>
            </div>
            <div class="tab-pane p-2" id="emails">
              <table id="email-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>SNo.</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Delivery</th>
                    <th>Response</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach ($email_records as $email_recs => $email_rec) { ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td>
                      <?= date('d-m-Y h:ia', strtotime($email_rec['created_on'])); ?>
                    </td>
                    <td>
                      <?= $email_rec['notif_type']; ?>
                    </td>
                    <td>
                        <?= $email_rec['response']; ?>
                    </td>
                    <td>
                        <?= $email_rec['req_response']; ?>
                    </td>
                  </tr>
                  <?php $i++; } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>    
    </div>
  </div>
</div>