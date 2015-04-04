<div class="cities form">
<?php echo $this->Form->create('City');?>
	<fieldset>
 		<legend><?php echo __('Add City');?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Cities'), array('action'=>'index'));?></li>
	</ul>
</div>
