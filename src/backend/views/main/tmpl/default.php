<?php
/*
 * @copyright  Copyright (C) 2016 Marco Beierer. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die('Restricted access');
?>

<div class="bootstrap3" style="margin-top: 10px;">
	<?php if ($this->phpVersionToOld): ?>
		<div class="alert alert-error">
			The Backup component needs at least PHP 5.6 and does not work with your current PHP version. Please upgrade your PHP version.
		</div>
	<?php endif; ?>

	<?php if ($this->zipLibVersionToOld): ?>
		<div class="alert alert-error">
			The Backup component needs at least the version 1.12.4 of the PHP zip extension and does not work with the current version of your zip extension. Upgrading your PHP version might help to solve the problem.
		</div>
	<?php endif; ?>

	<?php if (!$this->hasValidAccessKey): ?>
		<div class="alert alert-error">
			No access key set or access key is not long enough. It should have at least 16 characters.
		</div>
	<?php endif; ?>

	<?php if (!$this->hasValidEncryptionPassword): ?>
		<div class="alert alert-error">
			No encryption password set or encryption password is not long enough. It should have at least 16 characters.
		</div>
	<?php endif; ?>

	<?php if ($this->logData): ?>
		<h3>Logs</h3>
		<code style="display: block;"><?php echo nl2br($this->logData); ?></code>
	<?php endif; ?>

	<?php if ($this->debugMode): ?>
		<h3>Lock</h3>
		<p>Is locked: <span id="lockStatus">Loading ...</span></p>
		<p>
			<button id="lockBtn" class="btn">Lock</button>
			<button id="unlockBtn" class="btn">Unlock</button>
		</p>

		<script type="text/javascript">
			var refreshStatus = function() {
				jQuery.ajax({
					url: '<?php echo JURI::root(); ?>component/backup/lock',
					headers: {
						'Authorization': 'Bearer <?php echo $this->accessKey; ?>'
					}
				})
				.done(function(data) {
					var isLocked = data;
					jQuery('#lockStatus').html(isLocked);
				});
			};

			jQuery(document).ready(function() {
				refreshStatus();
			});

			jQuery('#lockBtn').click(function() {
				jQuery.ajax({
					url: '<?php echo JURI::root(); ?>component/backup/lock',
					method: 'POST',
					headers: {
						'Authorization': 'Bearer <?php echo $this->accessKey; ?>'
					}
				})
				.done(function(data) {
					refreshStatus();
				});
			});

			jQuery('#unlockBtn').click(function() {
				jQuery.ajax({
					url: '<?php echo JURI::root(); ?>component/backup/lock',
					method: 'DELETE',
					headers: {
						'Authorization': 'Bearer <?php echo $this->accessKey; ?>'
					}
				})
				.done(function(data) {
					refreshStatus();
				});
			});
		</script>
	<?php endif; ?>

	<h3>Credits</h3>
	<p>The Backup component for Joomla is developed and maintained by <a href="https://www.marcobeierer.com">Marco Beierer</a>. It is part of the <a href="https://www.websitetools.pro">Website Tools Professional</a> project.</p>
</div>
