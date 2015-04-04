<div class="articles index">
	<h2><?php echo __('Članki');?></h2>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Št. člankov: %count%')
	));
	?></p>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('Naslov', 'title');?></th>
		<th><?php echo $this->Paginator->sort('Objavljen', 'published');?></th>
		<th><?php echo $this->Paginator->sort('Pričetek objave', 'start');?></th>
		<th><?php echo $this->Paginator->sort('Ustvarjen', 'created');?></th>
		<th class="actions"><?php echo __('Možnosti');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($articles as $article):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
		<tr<?php echo $class;?>>
			<td>
				<?php echo $article['Article']['title']; ?>
			</td>
			<td>
				<?php
					if ($article['Article']['published'])
					{
						echo $this->Html->image('tick.png'); 	
					}
					else
					{
						echo $this->Html->image('cross.png'); 
					}
				?>
			</td>
			<td>
				<?php echo $this->Time->format('d.m.Y', $article['Article']['start']); ?>
			</td>
			<td>
				<?php echo $this->Time->format('H:m:s d.m.Y', $article['Article']['created']); ?>
			</td>
			<td class="actions">
				<?php echo $this->Html->link(__('Poglej'), array('action'=>'view', $article['Article']['slug'], 'admin' => FALSE)); ?>
				<?php echo $this->Html->link(__('Uredi'), array('action'=>'form', $article['Article']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('prejšnja'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
		<?php echo $this->Paginator->next(__('naslednja').' >>', array(), null, array('class'=>'disabled'));?>
	</div>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Nov članek'), array('action'=>'form')); ?></li>
	</ul>
</div>
