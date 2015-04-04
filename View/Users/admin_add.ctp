<div class="grid_3">
	<div class="box menu">
		<?php echo $this->element('admin/admin_left_menu-custom'); 	?>
	</div>
</div>

<div class="grid_13">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Add User');?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('group_id');
                echo $this->Form->input('hideprofile');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Users'), array('action'=>'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
	</ul>
</div>
