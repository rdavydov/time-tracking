<?php
$this->incView('include/page-top', false);
?>
<h1><?php echo $this->data->html('title'); ?></h1>
<div id="tabs" class="tabs">
	<ul id="tabs-nav" class="nav">
		<li><a href="#tab1"><?php TR::phtml('ui','info'); ?></a></li>
		<li><a href="#tab2"><?php TR::phtml('ui','history'); ?></a></li>
		<li><a href="#tab3"><?php TR::phtml('ui','report_spent'); ?></a></li>
	</ul>
	<div id="tab1" class="tab">
		<table class="info">
			<tbody>
				<tr>
					<th><?php TR::phtml('form','deadline'); ?></th>
					<td><?php echo $this->data->htmlDeadline(); ?></td>
				</tr>
				<tr>
					<th><?php TR::phtml('task','priority'); ?></th>
					<td><?php echo $this->data->htmlPriority(); ?></td>
				</tr>
				<tr>
					<th><?php TR::phtml('form','status'); ?></th>
					<td><?php echo $this->data->htmlStatus(); ?></td>
				</tr>
				<?php
				if (!$this->data->isEmpty('note')) {
				?>
				<tr>
					<th><?php TR::phtml('task','note'); ?></th>
					<td><?php echo $this->data->html('note'); ?></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<div id="tab2" class="tab">
		<?php
		$this->incView('include/timer-list');
		?>
	</div>
	<div id="tab3" class="tab">
		<?php
		$this->incView('include/timer-form');
		?>
	</div>
</div>
<script type="text/javascript">
var tabber = new Yetii({id: 'tabs'});
$('a.ajax').makeajax();
$('#f_task_timer').ajaxForm({
	target:	'#f_task_timer',
	data: {'ajax':'1'}
});
</script>
<?php /*
<script type="text/javascript" src="<?php echo APP_WWW_URI.'asset/js/jquery.dateentry.pack.js'; ?>"></script>
*/ ?>
<script type="text/javascript" src="<?php echo APP_WWW_URI.'asset/js/jquery.jdpicker.js'; ?>"></script>
<script type="text/javascript" src="<?php echo APP_WWW_URI.'asset/js/jquery.timeentry.pack.js'; ?>"></script>
<?php

$this->incView('include/page-bot', false);
