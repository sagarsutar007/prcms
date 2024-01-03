<?php 
  if (!empty($exam_log)){
      $exam_entry = date('h:i a d/m/Y', strtotime($exam_log['entered_at']));
      $exam_exit = date('h:i a d/m/Y', strtotime($exam_log['left_at']));
  } else {
      $exam_entry = 'Not Available';
      $exam_exit = 'Not Available';
  }
?>
<style>
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
        <?= "Exam conducted by <strong>" . $business['company_name'] . "</strong>"; ?>
      </p>
      <p style="text-align:center;margin: 0;">
        <?= "Exam Time: " . date( 'h:i a ', strtotime($exam['exam_datetime'])) . " to " . date( 'h:i a ', strtotime($exam['exam_endtime'])) . " on " . date('d/m/Y', strtotime($exam['exam_datetime'])); ?>
      </p>
    </div>
  </div>
</div>
<div class="container-fluid">
    <?php 
      $i= 1; 
      foreach ($result as $key => $obj) { 
        if (!empty($obj['question_en'])) { 
    ?>
      <div style="display:block; width:100%; margin-bottom: 15px;">
        <?php if ($exam['lang'] == "both" || $exam['lang'] == "eng") { ?> 
        <div style="display:block; width: 100%;">
          <?= "<h4 class='font-weight-bold' style='line-height: 1.3;'>".$i.". ".$obj['question_en']."</h4>"; ?>
          <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
            <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="50%" alt="">
          <?php } ?>
          <?php if ($obj['question_type'] != 'text') { ?>
            <ol type="A">
              <?php foreach ($obj['answers'] as $answers => $ans){ ?>
                <li style="line-height: 1.5;">
                  <?= $ans['answer_text_en']??'';?>
                </li>
              <?php } ?>
            </ol>
          <?php } ?>
          <div style="line-height: 1;"> 
            Correct answer: <?= $obj['correct_answer_en']; ?>
          </div>
        </div>
        <?php } ?>
        <?php if ($exam['lang'] == "both" || $exam['lang'] == "hindi") { ?> 
        <div style="display:block; width: 100%;">
          <?= "<h4 class='font-weight-bold hindi-font'>".$i.". ".$obj['question_hi']."</h4>"; ?>
          <?php if ( !empty($obj['question_img']) && file_exists('assets/img/' . $obj['question_img'])) { ?>
            <img src="<?= base_url('assets/img/' . $obj['question_img']); ?>" width="50%" alt="">
          <?php } ?>
          <?php if ($obj['question_type'] != 'text') { ?>
            <ol type="A">
              <?php foreach ($obj['answers'] as $answers => $ans){ ?>
                <li class="hindi-font" style="line-height: 1.5;">
                  <?= $ans['answer_text_hi']??'';?>
                </li>
              <?php } ?>
            </ol>
          <?php } ?>
          <div class="hindi-font" style="line-height: 1.5;"> 
            सही जवाब: <?= $obj['correct_answer_hi']; ?>
          </div>
        </div>
        <?php } ?>
        <div style="clear:both;"></div>
      </div>
    <?php } $i++; } ?>
</div>