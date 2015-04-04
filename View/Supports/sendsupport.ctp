<p>
Pišite nam, če:
<ul>
	<li>Potrebujete pomoč</li>
	<li>Imate predlog o izboljšavi spletne strani</li>
	<li>Bi radi stopili v stik z nami</li>
	<li>Bi radi sodelovali</li>
	<li>Ste odkrili napako</li>
</ul>
</p>
<?php

echo $this->Form->create('Support', array('class' => 'formStyle', 'default' => FALSE));

if (!$isLoggedIn)
{
	echo $this->Form->input('email', array('label' => 'E-mail', 'style' => 'width: 100%;'));
}
echo $this->Form->input('subject', array('label' => 'Zadeva', 'style' => 'width: 100%;'));
echo $this->Form->input('message', array('type' => 'textarea', 'label' => 'Sporočilo', 'style' => 'width: 97%; height: 150px;'));

echo $this->Js->submit('Dodaj', array('style' => 'display: none;', 'url' => array('controller' => 'supports', 'action' => 'sendsupport'), 'update' => '#tmpForm', 'id' => 'dodajBTN'));
echo $this->Form->end();

echo $this->Js->writeBuffer();
?>   