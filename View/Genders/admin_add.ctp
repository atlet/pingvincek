<div class="genders form">
<?php echo $this->Form->create('Gender');?>
	<fieldset>
 		<legend><?php echo __('Add Gender');?></legend>
	<?php
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Genders'), array('action'=>'index'));?></li>
		<li><?php echo $this->Html->link(__('List Profiles'), array('controller'=> 'profiles', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Profile'), array('controller'=> 'profiles', 'action'=>'add')); ?> </li>
	</ul>
</div>
