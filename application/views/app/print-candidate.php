<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <style>
          body {
            font-family: 'Source Sans Pro';
          }
          .header {
            background-color: #d8d8d8;
            min-height: 200px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: start;
          }
          .profile-img {
            margin: 0px 20px;
            border: 2px solid #f8f8f8;
            padding: 2px;
            background-color: #fff;
          }
          .profile-img img{
            height: 150px;
            width: 100px;
          }

          h1, p {
            margin: 0px;
          }

          .information {
            padding: 20px 0px;
          }

          .first-cell {
            width: 30%; 
            text-align: left;
            font-weight: bold;
          }

          .second-cell { 
            text-align: left;
          }

          .odd {
            background-color: #ececec;
          }

          .even {
            background-color: #ffffff;
          }

          .text-left {
            text-align: left!important;
          }
          .text-right {
            text-align: right!important;
          }
          .text-center {
            text-align: center!important;
          }
      @media print {
          body {
            font-family: 'Source Sans Pro';
          }
          .header {
            background-color: #d8d8d8;
            min-height: 200px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: start;
          }
          .profile-img {
            margin: 0px 20px;
            border: 2px solid #f8f8f8;
            padding: 2px;
            background-color: #fff;
          }
          .profile-img img{
            height: 150px;
            width: 100px;
          }

          h1, p {
            margin: 0px;
          }

          .information {
            padding: 10px 0px 0px;
          }

          .first-cell {
            width: 20%; 
            text-align: left;
            font-weight: bold;
          }

          .second-cell { 
            text-align: left;
          }

          .odd {
            background-color: #ececec;
          }

          .even {
            background-color: #ffffff;
          }

          .text-left {
            text-align: left!important;
          }
          .text-right {
            text-align: right!important;
          }
          .text-center {
            text-align: center!important;
          }
      }
    </style>
  </head>
  <body>
    <div class="header">
      <?php if (!empty($record['profile_img']) && file_exists('./assets/img/'.$record['profile_img'])) { ?>
        <div class="profile-img">
          <img src="<?= base_url('./assets/img/'.$record['profile_img']); ?>" alt="">
        </div>
        <?php } else { ?>
        <div class="profile-img">
          <img src="<?= base_url('./assets/img/letter-p.png'); ?>" alt="">
        </div>
        <?php } ?>
        <div>
          <h1><?= $record['firstname'] . " " . $record['middlename']  . " " .  $record['lastname']; ?></h1>
          <p>Phone: +91 <?= $record['phone']??'Not Available'; ?></p>
          <p>Email: <?= $record['email']??'Not Available'; ?></p>
          <p>Aadhaar: <?= $record['aadhaar_number']??'Not Available'; ?></p>
          <p>Employee ID: <?= $record['empid']??'Not Available'; ?></p>
        </div>
    </div>
    <div class="information">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr class="odd">
          <td class="first-cell">
            Father's Name 
          </td>
          <td class="second-cell">
            : <?= $record['father_name']??'Not Available'; ?>
          </td>
          <td class="first-cell">
            Bank's Name 
          </td>
          <td class="second-cell">
            : <?= $record['bank_name']??'Not Available'; ?>
          </td>
        </tr>
        <tr class="even">
          <td class="first-cell">
            Date of Birth
          </td>
          <td class="second-cell">
            : <?php if(!empty($record['dob'])){ echo date('d-m-Y', strtotime($record['dob'])); }; ?>
          </td>
          <td class="first-cell">
            Account Number 
          </td>
          <td class="second-cell">
            : <?= $record['account_num']??'Not Available'; ?>
          </td>
        </tr>
        <tr class="odd">
          <td class="first-cell">
            Gender 
          </td>
          <td class="second-cell">
            : <?= $record['gender']??'Not Available'; ?>
          </td>
          <td class="first-cell">
            IFSC Code 
          </td>
          <td class="second-cell">
            : <?= $record['ifsc_code']??'Not Available'; ?>
          </td>
        </tr>
        <tr class="even">
          <td class="first-cell">
            WhatsApp 
          </td>
          <td class="second-cell">
            : <?= $record['whatsapp_number']??'Not Available'; ?>
          </td>
          <td class="first-cell">
            Passbook
          </td>
          <td class="second-cell">
            : <?php if ( !empty($record['passbook_pic']) && file_exists('./assets/img/'.$record['passbook_pic'])) { echo 'Uploaded'; } else { echo 'Not uploaded'; } ?>
          </td>
        </tr>
        <tr class="odd">
          <td class="first-cell">
            Marital Status
          </td>
          <td class="second-cell">
            : <?= !empty($record['marital_status'])?ucfirst($record['marital_status']):'Not Available'; ?>
          </td>
          <td class="first-cell">
            Chequebook
          </td>
          <td class="second-cell">
            : <?php if ( !empty($record['chequebook_pic']) && file_exists('./assets/img/'.$record['chequebook_pic'])) { echo 'Uploaded'; } else { echo 'Not uploaded'; } ?>
          </td>
        </tr>
        <tr class="even">
          <td class="first-cell">
            Qualification
          </td>
          <td class="second-cell">
            : <?= $record['highest_qualification']; ?>
          </td>
          <td class="first-cell">
            Business Unit
          </td>
          <td class="second-cell">
            : <?= $company['company_name']; ?>
          </td>
        </tr>
      </table>
    </div>
    <div class="information p-0">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <thead>
          <tr>
            <th class="text-left">Present Address</th>
            <th class="text-left">Permanent Address</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="50%">
                <?php
                  $address = $record['ca_address'];
                  $landmark = $record['ca_address_landmark'];
                  $city = $record['ca_city'];
                  $dist = $record['ca_dist'];
                  $state = $record['ca_state'];
                  $pin = $record['ca_pin'];

                  echo $address . (!empty($address) ? "<br/>" : "") .
                      $landmark . (!empty($landmark) ? "<br/>" : "") .
                      $city . (!empty($city) ? "<br/>" : "") .
                      $dist . (!empty($dist) ? "<br/>" : "") .
                      $state . (!empty($state) ? "<br/>" : "") .
                      $pin;
                  ?>
            </td>
            <td width="50%">
                <?php
                  $address = $record['pa_address'];
                  $landmark = $record['pa_address_landmark'];
                  $city = $record['pa_city'];
                  $dist = $record['pa_dist'];
                  $state = $record['pa_state'];
                  $pin = $record['pa_pin'];

                  echo $address . (!empty($address) ? "<br/>" : "") .
                      $landmark . (!empty($landmark) ? "<br/>" : "") .
                      $city . (!empty($city) ? "<br/>" : "") .
                      $dist . (!empty($dist) ? "<br/>" : "") .
                      $state . (!empty($state) ? "<br/>" : "") .
                      $pin;
                  ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="information">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <thead>
          <tr>
            <th class="text-left">Aadhaar Front</th>
            <th class="text-left">Aadhaar Back</th>
            <th class="text-left">Voter ID Photo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="25%">
              <?php if (!empty($record['aadhaar_card_front_pic']) && file_exists('./assets/img/'.$record['aadhaar_card_front_pic'])) { ?>
                <img src="<?= base_url('assets/img/'.$record['aadhaar_card_front_pic']); ?>" class="rounded img-thumbnail" style="width: 100%;" alt="Aadhaar Front Photo">
              <?php } ?>
            </td>
            <td width="25%">
              <?php if (!empty($record['aadhaar_card_back_pic']) && file_exists('./assets/img/'.$record['aadhaar_card_back_pic'])) { ?>
                <img src="<?= base_url('assets/img/'.$record['aadhaar_card_back_pic']); ?>" class="rounded img-thumbnail" style="width: 100%;" alt="Aadhaar Back Photo">
              <?php } ?>
            </td>
            <td width="25%">
              <?php if ( !empty($record['voter_id']) && file_exists('./assets/img/'.$record['voter_id'])) { ?>
                <img src="<?= base_url('assets/img/'.$record['voter_id']); ?>" class="rounded img-thumbnail" style="width: 100%;" alt="Voter Picture">
              <?php } ?>
            </td>
          </tr>
          <tr>
            <th class="text-left">Pancard Photo</th>
            <th class="text-left">Passbook Photo</th>
            <th class="text-left">Chequebook Photo</th>
          </tr>
          <tr>
            <td width="25%">
              <?php if (!empty($record['pancard_pic']) && file_exists('./assets/img/'.$record['pancard_pic'])) { ?>
                <img src="<?= base_url('assets/img/'.$record['pancard_pic']); ?>" class="rounded img-thumbnail" style="width: 100%;" alt="Pancard Picture">
              <?php } ?>
            </td>
            <td>
              <?php if ( !empty($record['passbook_pic']) && file_exists('./assets/img/'.$record['passbook_pic'])) { ?>
                <img src="<?= base_url('assets/img/'.$record['passbook_pic']); ?>" class="rounded img-thumbnail" style="width: 100%;" alt="Passbook Picture">
              <?php } ?>
            </td>
            <td>
              <?php if ( !empty($record['chequebook_pic']) && file_exists('./assets/img/'.$record['chequebook_pic'])) { ?>
                <img src="<?= base_url('assets/img/'.$record['chequebook_pic']); ?>" class="rounded img-thumbnail" style="width: 100%;" alt="Chequebook Picture">
              <?php } ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="information">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td class="text-left">
            Date: __/__/_____ <br/>
            Location: _______________
          </td>
          <td class="text-right">
            <div class="text-center">_____________________ <br/>Signature</div>
          </td>
        </tr>
      </table>
    </div>
    <script>
      window.print();
    </script>
  </body>
</html>
