<div class="cities index">
<h2><?php echo __('Cities');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('geonameid');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('modificationDate');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($cities as $city):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $city['City']['geonameid']; ?>
		</td>
		<td>
			<?php echo $city['City']['name']; ?>
		</td>
		<td>
			<?php echo $city['City']['modificationDate']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action'=>'view', $city['City']['geonameid'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action'=>'edit', $city['City']['geonameid'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action'=>'delete', $city['City']['geonameid']), null, sprintf(__('Are you sure you want to delete city %s?'), $city['City']['name'])); ?>
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
		<li><?php echo $this->Html->link(__('New City'), array('action'=>'add')); ?></li>
	</ul>
</div>
