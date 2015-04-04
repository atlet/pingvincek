<div class="genders view">
<h2><?php echo __('Gender');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gender['Gender']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gender['Gender']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gender['Gender']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gender['Gender']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Gender'), array('action'=>'edit', $gender['Gender']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Gender'), array('action'=>'delete', $gender['Gender']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $gender['Gender']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Genders'), array('action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gender'), array('action'=>'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Profiles'), array('controller'=> 'profiles', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Profile'), array('controller'=> 'profiles', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Profiles');?></h3>
	<?php if (!empty($gender['Profile'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Kratekopis'); ?></th>
		<th><?php echo __('Opis'); ?></th>
		<th><?php echo __('Slika'); ?></th>
		<th><?php echo __('Ime'); ?></th>
		<th><?php echo __('Rojstnidatum'); ?></th>
		<th><?php echo __('Gender Id'); ?></th>
		<th><?php echo __('Lgender Id'); ?></th>
		<th><?php echo __('Smoker Id'); ?></th>
		<th><?php echo __('Drinker Id'); ?></th>
		<th><?php echo __('City Id'); ?></th>
		<th><?php echo __('Region Id'); ?></th>
		<th><?php echo __('Searchfor Id'); ?></th>
		<th><?php echo __('Colors Id'); ?></th>
		<th><?php echo __('Bodyt Id'); ?></th>
		<th><?php echo __('Status Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($gender['Profile'] as $profile):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $profile['id'];?></td>
			<td><?php echo $profile['user_id'];?></td>
			<td><?php echo $profile['kratekopis'];?></td>
			<td><?php echo $profile['opis'];?></td>
			<td><?php echo $profile['slika'];?></td>
			<td><?php echo $profile['ime'];?></td>
			<td><?php echo $profile['rojstnidatum'];?></td>
			<td><?php echo $profile['gender_id'];?></td>
			<td><?php echo $profile['lgender_id'];?></td>
			<td><?php echo $profile['smoker_id'];?></td>
			<td><?php echo $profile['drinker_id'];?></td>
			<td><?php echo $profile['city_id'];?></td>
			<td><?php echo $profile['region_id'];?></td>
			<td><?php echo $profile['searchfor_id'];?></td>
			<td><?php echo $profile['colors_id'];?></td>
			<td><?php echo $profile['bodyt_id'];?></td>
			<td><?php echo $profile['status_id'];?></td>
			<td><?php echo $profile['created'];?></td>
			<td><?php echo $profile['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller'=> 'profiles', 'action'=>'view', $profile['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller'=> 'profiles', 'action'=>'edit', $profile['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller'=> 'profiles', 'action'=>'delete', $profile['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $profile['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Profile'), array('controller'=> 'profiles', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
