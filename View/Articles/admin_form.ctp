<div class="articles form">
<?php echo $this->Form->create('Article');?>
	<fieldset>
		<legend><?php echo __('Članek');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('label' => 'Naslov'));
		echo $this->Form->input('body', array('label' => 'Vsebina'));
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('SEO');?></legend>
		<?php
			echo $this->Form->input('slug', array('label' => 'SLUG (naslov-clanka)'));
			echo $this->Form->input('description', array('label' => 'Kratek opis/povzetek članka'));
			echo $this->Form->input('keywords', array('label' => 'Ključne besede (kljucna, beseda, clanek)'));
		?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('Ostalo');?></legend>
		<?php
			echo $this->Form->input('published', array('label' => 'Objavljen'));
			echo $this->Form->input('start', array('label' => 'Datum pričetka objave', 'dateFormat' => 'DMY'));
		?>
	</fieldset>
<?php echo $this->Form->end('Shrani');?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Spisek člankov'), array('action'=>'index'));?></li>
	</ul>
</div>

<script>
	$( '#ArticleBody' ).ckeditor();
</script>