<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/styles.css'); ?>">
  </head>
  <body>
    <h1><?= $exam['name']; ?></h1>
    <p>Date: <?= date('d-m-Y H:i:s', strtotime($exam['exam_datetime'])); ?></p>
    <p>Duration: <?= $exam['duration']; ?> Minutes</p>
    <p>Language: <?php 
      if ($exam['lang'] == 'eng') {
        echo "English";
      } else if ($exam['lang'] == 'both') {
        echo "Hindi & English";
      } else {
        echo "Hindi";
      }
    ?></p>
    <p>Total Candidates: <?= $exam['total_candidates']??''; ?></p>
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
      <thead>
          <tr>
            <th style="width: 1%">#</th>
            <th style="width: 20%">Candidate Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Status</th>
          </tr>
      </thead>
      <tbody>
        <?php $i=1; if (isset($results)) { foreach ($results as $records => $record) { ?>
          <tr>
            <td>
              <?= $i; ?>
            </td>
            <td><?= ucwords($record['firstname'] . " " . $record['middlename'] . " " . $record['lastname']); ?></td>
            <td><?= $record['phone']; ?></td>
            <td><?= $record['email']; ?></td>
            <td><?= $record['gender']?ucfirst($record['gender']):'Not Available'; ?></td>
            <td><?= $record['ans_stats']??''; ?></td>
          </tr>
        <?php $i++; } } ?>
      </tbody>
    </table>
  </body>
</html>
