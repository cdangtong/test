<?php
use Awf\Document\Document;

/** @var Document $this */

foreach (array(
	'error'		=> 'danger',
	'warning'	=> 'warning',
	'success'	=> 'success',
	'info'		=> 'info',
	) as $type => $class):
	$messages = $this->getContainer()->application->getMessageQueueFor($type);

	if (!empty($messages)):
		$class = "alert-$class";
?>
<div id="akeeba-backup-message-<?php echo $type ?>" class="akeeba-backup-message alert <?php echo $class ?>">
<?php foreach($messages as $message):?>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<p><?php echo $message ?></p>
<?php endforeach; ?>
</div>
<?php
	endif;
endforeach;
$this->getContainer()->application->clearMessageQueue();