<div class="groups index">
<h2><?php echo __('Spisek skupin');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Vseh skupin: %count%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('Ime skupine', 'name');?></th>
	<th class="actions"><?php echo __('Možnosti');?></th>
</tr>
<?php
$i = 0;
foreach ($groups as $group):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $group['Group']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action'=>'view', $group['Group']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action'=>'edit', $group['Group']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action'=>'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $group['Group']['id'])); ?>
			<?php echo $this->Html->link(__('Security'), array('action'=>'security', $group['Group']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class'=>'disabled'));?>
</div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Group'), array('action'=>'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
