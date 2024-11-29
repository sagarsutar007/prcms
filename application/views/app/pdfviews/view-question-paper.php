<?php 
  if (!empty($exam_log)){
      $exam_entry = date('h:i a d/m/Y', strtotime($exam_log['entered_at']));
      $exam_exit = date('h:i a d/m/Y', strtotime($exam_log['left_at']));
  } else {
      $exam_entry = 'Not Available';
      $exam_exit = 'Not Available';
  }

  $company = "";
  if(!empty($business)) {
    $company = $business['company_name'];
  }
?>
<style>
  .answer-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr); /* Two columns */
      gap: 10px; /* Space between items */
      margin: 0;
      padding: 0;
  }

  .answer-item {
      padding: 5px;
      background: #f9f9f9; /* Optional: Light background for each item */
      font-size: 14px; /* Font size for text */
  }
  /* devanagari */
  /*@font-face {
    font-family: 'Hind';
    font-style: normal;
    font-weight: 400;
    src: url(https://fonts.gstatic.com/s/hind/v16/5aU69_a8oxmIdGh6BCOz.woff2) format('woff2');
    unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
  }
  /* latin-ext */
  /*@font-face {
    font-family: 'Hind';
    font-style: normal;
    font-weight: 400;
    src: url(https://fonts.gstatic.com/s/hind/v16/5aU69_a8oxmIdGd4BCOz.woff2) format('woff2');
    unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
  }*/
  /* latin */
  @font-face {
    font-family: 'Hind';
    font-style: normal;
    font-weight: 400;
    src: url(https://fonts.gstatic.com/s/hind/v16/5aU69_a8oxmIdGl4BA.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
  }
  /* devanagari */
  @font-face {
    font-family: 'Hind';
    font-style: normal;
    font-weight: 700;
    src: url(https://fonts.gstatic.com/s/hind/v16/5aU19_a8oxmIfNJdER2SjQpf.woff2) format('woff2');
    unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
  }
  /* latin-ext */
  @font-face {
    font-family: 'Hind';
    font-style: normal;
    font-weight: 700;
    src: url(https://fonts.gstatic.com/s/hind/v16/5aU19_a8oxmIfNJdERKSjQpf.woff2) format('woff2');
    unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
  }
  /* latin */
  @font-face {
    font-family: 'Hind';
    font-style: normal;
    font-weight: 700;
    src: url(https://fonts.gstatic.com/s/hind/v16/5aU19_a8oxmIfNJdERySjQ.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
  }

  .hindi-font {
    font-family: 'freeserif';
    line-height: 1;
  }
</style>
<div class="container">
  <div class="row">
    <div style="display:block;width:100%;margin-bottom: 15px;">
      <p style="text-align:center;margin: 0;">
        <?= "Exam conducted by <strong>" . $company??'' . "</strong>"; ?>
      </p>
      <p style="text-align:center;margin: 0;">
        <?= "Exam Time: " . date( 'h:i a ', strtotime($exam['exam_datetime'])) . " to " . date( 'h:i a ', strtotime($exam['exam_endtime'])) . " on " . date('d/m/Y', strtotime($exam['exam_datetime'])); ?>
      </p>
    </div>
  </div>
</div>
<div style="width:100%;">
  <?php 
    $totalResults = count($result);

    if ($config['pdf_language_config'] == 3) {
      $i=1;
      foreach ($result as $key => $obj) { 
        if (!empty($obj['question_en'])) { 
  ?>
        <div style="display:block; width:100%; margin-bottom: 15px;">
          <div style="width: 49%; float:left;">
            <?= "<h4 class='font-weight-bold' style='line-height: 1.3;'>".$i.". ".$obj['question_en']."</h4>"; ?>
            <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
              <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="40%" alt="">
            <?php } ?>
            <?php if ($obj['question_type'] != 'text') { ?>
                <div class="answer-grid">
                    <?php foreach ($obj['answers'] as $index => $ans) { ?>
                        <div class="answer-item">
                            <?= chr(65 + $index) . ". " . ($ans['answer_text_en'] ?? ''); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div style="line-height: 1; display:<?= $config['pdf_question_options_config']==1?'none':'inline'; ?>;"> 
              <b>Correct answer</b>: <?= $obj['correct_answer_en']; ?>
            </div>
          </div>
          <div style="width: 49%; float:right;">
            <?= "<h4 class='font-weight-bold hindi-font'>".$i.". ".$obj['question_hi']."</h4>"; ?>
            <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
              <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="40%" alt="">
            <?php } ?>
            <?php if ($obj['question_type'] != 'text') { ?>
                <div class="answer-grid">
                    <?php foreach ($obj['answers'] as $index => $ans) { ?>
                        <div class="answer-item hindi-font">
                            <?= chr(65 + $index) . ". " . ($ans['answer_text_hi'] ?? ''); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="hindi-font" style="line-height: 1.5; display:<?= $config['pdf_question_options_config']==1?'none':'inline'; ?>;"> 
              <b>सही जवाब</b>: <?= $obj['correct_answer_hi']; ?>
            </div>
          </div>
          <div style="clear:both;"></div>
        </div>
  <?php
        }
        $i++;
      }
    } elseif ($config['pdf_language_config'] == 2) {
      $i=1;
      foreach ($result as $key => $obj) { 
        if (!empty($obj['question_en'])) { 
  ?>
      <div style="width: 49%; float:<?= ($i%2==0)?'right':'left'; ?>;">
        <?= "<h4 class='font-weight-bold hindi-font'>".$i.". ".$obj['question_hi']."</h4>"; ?>
        <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
          <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="40%" alt="">
        <?php } ?>
        <?php if ($obj['question_type'] != 'text') { ?>
            <div class="answer-grid">
                <?php foreach ($obj['answers'] as $index => $ans) { ?>
                    <div class="answer-item hindi-font">
                        <?= chr(65 + $index) . ". " . ($ans['answer_text_hi'] ?? ''); ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="hindi-font" style="line-height: 1.5; display:<?= $config['pdf_question_options_config']==1?'none':'inline'; ?>;"> 
          <b>सही जवाब</b>: <?= $obj['correct_answer_hi']; ?>
        </div>
      </div>
  <?php } if($i%2==0){ ?>
  <div style="clear:both;"></div>
  <?php
        }
        $i++;
      }
    } elseif ($config['pdf_language_config'] == 1) {
?>

  <?php
      $i=1;
      foreach ($result as $key => $obj) { 
        if (!empty($obj['question_en'])) { 
  ?>
          <div style="width: 49%; float:<?= ($i%2==0)?'right':'left'; ?>;">
            <?= "<h4 class='font-weight-bold' style='line-height: 1.3;'>".$i.". ".$obj['question_en']."</h4>"; ?>
            <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
              <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="40%" alt="">
            <?php } ?>
            <?php if ($obj['question_type'] != 'text') { ?>
                <div class="answer-grid">
                    <?php foreach ($obj['answers'] as $index => $ans) { ?>
                        <div class="answer-item">
                            <?= chr(65 + $index) . ". " . ($ans['answer_text_en'] ?? ''); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div style="line-height: 1; display:<?= $config['pdf_question_options_config']==1?'none':'inline'; ?>;"> 
              <b>Correct answer</b>: <?= $obj['correct_answer_en']; ?>
            </div>
          </div>
  <?php }
    if($i%2==0){
  ?>
  <div style="clear:both;"></div>
  <?php
    }
        $i++;
      }
    }
  ?>
</div>