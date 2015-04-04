<div class="groups form">
<?php echo $this->Form->create('Group');?>
	<fieldset>
 		<legend><?php echo __('Add Group');?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Groups'), array('action'=>'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
