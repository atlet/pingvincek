<h2>Zadnjih 5 prijavljenih uporabnikov</h2>
<p>Št. vseh uporabnikov <?php echo $stUporabnikov ; ?> od tega aktivnih <?php echo $stUporabnikov - $stUporabnikovBan; ?> in bananih <?php echo $stUporabnikovBan; ?>.</p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>Id</th>
	<th>Nickname</th>
	<th>Username</th>
	<th>Ban</th>
	<th>Created</th>
	<th>Lastlogin</th>
	<th class="actions">Actions</th>
</tr>
<?php
$i = 0;
foreach ($zadnjiPrijavljeni as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['id']; ?>
		</td>
		<td>
			<?php echo $user['User']['nickName']; ?>
		</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['ban']; ?>
		</td>
		<td>
			<?php echo $this->Time->format( $format = 'H:i:s d-m-Y', $user['User']['created']); ?>
		</td>
		<td>
			<?php echo $this->Time->format( $format = 'H:i:s d-m-Y', $user['User']['lastlogin']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action'=>'view', $user['User']['id'], 'admin' => FALSE)); ?>
			<?php echo $this->Html->link(__('Edit'), array('action'=>'edit', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<h2>Zadnjih 5 prijav</h2>

<table cellpadding="0" cellspacing="0">
	<tr>
		<th>Reported user</th>
		<th>Message</th>
		<th>Created</th>
	</tr>
	<?php
	$i       = 0;
	foreach ($zadnjePrijave as $report):
		$class = null;
		if ($i++ % 2 == 0)
		{
			$class = ' class="altrow"';
		}
		?>
		<tr<?php echo $class; ?>>
			<td>
				<?php echo $this->Html->link($report['Report']['user_id'], array('controller' => 'users', 'action' => 'view', $report['Report']['user_id'], 'admin' => FALSE)); ?>
			</td>
			<td>
				<?php echo $this->Html->link($report['Report']['message'], array('action' => 'view', $report['Report']['id'])); ?>
			</td>
			<td>
				<?php echo $this->Time->format($format  = 'H:i:s d-m-Y', $report['Report']['created']); ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<h2>Zadnjih 5 spam sporočil</h2>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th>Subject</th>
		<th>Message</th>
		<th>From user</th>
		<th>Created</th>
	</tr>
	<?php
	$i       = 0;
	foreach ($zadnjiSpam as $spam):
		$class = null;
		if ($i++ % 2 == 0)
		{
			$class = ' class="altrow"';
		}
		?>
		<tr<?php echo $class; ?>>
			<td>
				<?php echo $spam['Message']['subject']; ?>
			</td>
			<td>
				<?php echo $spam['Message']['message']; ?>
			</td>
			<td>
				<?php echo $this->Html->link($spam['Message']['from_user_id'], array('controller' => 'users', 'action' => 'view', $spam['Message']['from_user_id'], 'admin' => FALSE)); ?>
			</td>
			<td>
				<?php echo $this->Time->format($format  = 'H:i:s d-m-Y', $spam['Message']['created']); ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>