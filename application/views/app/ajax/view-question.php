<div class="row">
  <div class="col-md-10 mx-auto">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <?php if (!empty($question['question_img']) && file_exists('./assets/img/'.$question['question_img'])) { ?>
          <div class="col-md-4">
            <img src="<?= base_url('assets/img/'.$question['question_img']); ?>" class="img-fluid img-responsive" alt="">
          </div>
          <?php } ?>
          <div class="col-md">
            <?php 
              $que = "";
              if (strlen($question['question_en']) > 2) {
                $que .= "Q. " . $question['question_en'];
              }

              if (strlen($question['question_hi']) > 2) {
                $que .= "<div class='mb-2'></div> स. " . $question['question_hi'];
              }
            ?>
            <h3><strong><?= $que; ?></strong></h3>
            <br>
            <?php 
              if ($question['question_type'] != 'text') {
                $i = 1;
                foreach ($answers as $answers => $ans) {
            ?>
            <div class="form-group m-0 p-0 d-flex align-items-top">
              <div>
                <?= $i; ?>. &nbsp;
              </div>
              <label style="font-weight: 400;">
                <?php 
                  if (strlen($ans['answer_text_en']) > 0) {
                    echo $ans['answer_text_en'];
                  }

                  if (strlen($ans['answer_text_hi']) > 0) {
                    echo "<br>" . $ans['answer_text_hi'];
                    $fs = "30px";
                  }
                ?>
              </label>
              <?php if ($ans['isCorrect'] == 1) { ?>
                <i class="fas fa-check text-success ml-3" style="font-size: <?= $fs??'20px'; ?>; padding-top: 5px;"></i>
              <?php } ?>
            </div>
            <?php $i++; } } else { ?>
            <div class="form-group m-0 p-0">
              <textarea name="answerId" id="<?= 'ans-'.$ans['id']; ?>" cols="30" rows="10"></textarea>
            </div>
            <?php } ?>
          </div>
        </div>    
      </div>
    </div>  
  </div>
</div>