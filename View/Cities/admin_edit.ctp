<div class="cities form">
<?php echo $this->Form->create('City');?>
	<fieldset>
 		<legend><?php echo __('Edit City');?></legend>
	<?php
		echo $this->Form->input('geonameid');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete'), array('action'=>'delete', $this->Form->value('City.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('City.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Cities'), array('action'=>'index'));?></li>
	</ul>
</div>
