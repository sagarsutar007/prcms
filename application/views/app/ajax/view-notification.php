<div class="alert alert-info"><?= ucfirst($record['response']); ?><?= $record['req_response']?", " . html_entity_decode($record['req_response']):''; ?></div>
<br/>
<?= str_replace("700px", "500px", html_entity_decode($record['text'])); ?>