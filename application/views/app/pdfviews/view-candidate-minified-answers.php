<?php 
  if (!empty($exam_log)){
      $exam_entry = !empty($exam_log['entered_at'])?date('h:i a d/m/Y', strtotime($exam_log['entered_at'])):'Not Available';
      $exam_exit = !empty($exam_log['left_at'])?date('h:i a d/m/Y', strtotime($exam_log['left_at'])):'Not Available';
  } else {
      $exam_entry = 'Not Available';
      $exam_exit = 'Not Available';
  }
?>
<style>
    .container {
        width: 100%;
        overflow: hidden;
    }
    .column {
        float: left;
        box-sizing: border-box;
    }
    .left-column {
        width: 49%;
        background-color: #f9f9f9;
    }
    .right-column {
        width: 49%;
        background-color: #f9f9f9;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #333;
        padding: 2px;
        text-align: center;
        box-sizing: border-box;
    }
    th, td:nth-child(2), td:nth-child(3), td:nth-child(4), td:nth-child(5), td:nth-child(6), td:nth-child(7), td:nth-child(8) {
        width: 10%;
    }
    th:first-child, td:first-child {
        width: 5%;
    }
    th:last-child, td:last-child {
        width: 10%;
    }
</style>
<div class="container">
  <div class="row">
    <div style="display:block;width:100%;margin-bottom: 15px;">            
      <h2 style="text-align:center;margin-bottom:0;">
        <?= $clients; ?>
      </h2>
      <h3 style="text-align:center;margin-bottom:0;">
        <?= $exam['name']; ?>
      </h3>
      <p style="text-align:center;margin: 0;">
        <?= "Exam conducted by <strong>" . $business['company_name'] . "</strong>"; ?>
      </p>
      <p style="text-align:center;margin: 0;"><?= "Exam Time: " . date( 'h:i a ', strtotime($exam['exam_datetime']??time())) . " to " . date( 'h:i a ', strtotime($exam['exam_endtime']??time())) . " on " . date('d/m/Y', strtotime($exam['exam_datetime']??time())); ?></p>
    </div>
    <div style="width: 44%; float:left; text-align: right; padding-top: 15px;">
      <?php
          if (isset($user['profile_img']) && !empty($user['profile_img']) && file_exists('assets/img/thumbnails/' . $user['profile_img']) ) {
            $prof_img = base_url('assets/img/thumbnails/' . $user['profile_img']);
          }else {
            if ($user['gender'] == "male") {
              $prof_img = base_url('assets/admin/img/avatar.png');
            } else if ($user['gender'] == "female") {
              $prof_img = base_url('assets/admin/img/avatar2.png');
            } else {
              $prof_img = base_url('assets/admin/img/user-avatar.png');
            }
          }
      ?>
      <img src="<?= $prof_img; ?>" style="height: 120px;" alt="">
    </div>
    <div style="width: 53%; float:right; text-align: left; font-style: 13px; line-height: 1.5;">
      <strong><?= ucwords($user['firstname']. " " .$user['middlename']??''. " " .$user['lastname']??'' ) ?></strong><br/>
      <?= "Email : " . $user['email']; ?> <br/>
      <?= "Phone :  +91" . $user['phone']; ?> <br/>
      <?= "Aadhaar: " . $user['aadhaar_number']; ?> <br/>
      <?= "Employee ID: " . $user['empid']; ?> <br/>
      <?= "Gender: " . $user['gender']; ?> <br/>
      <?= "Exam Started at: " .$exam_entry; ?> <br/>
      <?= "Exam Ended at: " .$exam_exit; ?> <br/>
    </div>
    <div style="clear:both;"></div>
  </div>
</div>
<div class="container">
  <?php
      $total_questions = count($result);
      
      if ($total_questions < 50) {
        $max_rows = 50;
      } else {
        $max_rows = ceil(($total_questions - 50) / 100) * 100 + 50;
      }

      $first_page_records = 50;
      $other_pages_records = 100;

      if ($total_questions <= $first_page_records) {
        $pages = 1;
      } else {
        $remaining_questions = $total_questions - $first_page_records;
        $additional_pages = ceil($remaining_questions / $other_pages_records);
        $pages = 1 + $additional_pages;
      }
      
      $maxRowsPerColumn = 25;
      $totalRows = $max_rows;
      
      $numColumns = ceil($totalRows / $maxRowsPerColumn);

      $optionHeaders = range('A', 'Z'); 
  ?>
  <?php for ($col = 0; $col < $numColumns; $col++): ?>
    <div class="column <?= ($col % 2 == 0) ? 'left-column' : 'right-column' ?>">
      <table cellpadding="0" cellspacing="0" border="1">
          <thead>
              <tr>
                  <th>Qno.</th>
                  <?php for ($j = 0; $j < $max_options; $j++): ?>
                      <th><?= $optionHeaders[$j]; ?></th>
                  <?php endfor; ?>
                  <th>Status</th>
              </tr>
          </thead>
          <tbody>
              <?php 
                $startIndex = $col * $maxRowsPerColumn;
                $endIndex = min($startIndex + $maxRowsPerColumn, $totalRows);
                
                for ($i = $startIndex; $i < $endIndex; $i++){ 
                  $ansStatus = $result[$i]['answer_status']??'';
              ?>
              <tr>
                  <td><?= $i + 1; ?></td>
                  <?php 
                    for ($j = 0; $j < $max_options; $j++) {
                        if (isset($result[$i]['answers'][$j])) {
                          $answer = $result[$i]['answers'][$j];
                          if ($answer['id'] == $result[$i]['user_answer_id']) {
                            if ($answer['isCorrect'] == 1) {
                              echo "<td style='color:green;text-align:center;'><img src='". base_url('assets/admin/img/check.png') ."' width=\"16px\"></td>";
                            } else {
                              echo "<td style='color:red;text-align:center;'><img src='". base_url('assets/admin/img/remove.png') ."' width=\"16px\"></td>";
                            }
                          } else {
                            echo "<td><input type=\"checkbox\" /></td>";
                          }
                        } else {
                          echo "<td><input type=\"checkbox\" /></td>";
                        }
                    } 
                  ?>
                  <td>
                    <?php 
                      if ($ansStatus == 2) {
                        echo '<span>Not Answered</span>';
                      } else if ($ansStatus == 1) {
                        echo '<span style="color:green;">Correct</span>';
                      } else if ($ansStatus == 3) {
                        echo '<span style="color:red;">Incorrect</span>';
                      }
                    ?>
                  </td>
              </tr>   
              <?php } ?>
          </tbody>
      </table>
    </div>
  <?php endfor; ?>
</div>
