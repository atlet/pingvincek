<?php

echo $this->Form->create('Report', array('class' => 'formStyle', 'default' => FALSE));

echo $this->Form->hidden('user_id');
echo $this->Form->hidden('reporter_user_id');

echo $this->Form->input('message', array('label' => 'Sporočilo'));

echo $this->Js->submit('Dodaj', array('style' => 'display: none;', 'url' => array('controller' => 'reports', 'action' => 'add', $uid), 'update' => '#tmpForm', 'id' => 'dodajBTN'));
echo $this->Form->end();

echo $this->Js->writeBuffer(); 
?>   