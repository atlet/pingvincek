<div class="h1-naslov">
    <h1>Ustvarite si nov račun - brezplačno!</h1>
</div>
<p>
S tem vam bo omogočeno:
<ul>
	<li>Iskanje idealnega partnerja</li>
	<li>Dopisovanje s člani</li>
	<li>...</li>
</ul>
</p>

<p>Vnesite vaš e-mail naslov, na katerega vam bo poslano geslo za dostop.</p>
<br>
<div class="users form">
<?php echo $this->Form->create('User', array('class' => 'formStyle'));?>
	<?php

		echo $this->Form->input('User.username', array('label' => 'E-mail:'));
	?>
<?php echo $this->Form->end('Potrdi registracijo');?>
</div>