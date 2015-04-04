<div class="span-19">
    <h1>Novo privatno sporočilo</h1>

<?php
    echo $this->Form->create('Message', array('action' => 'newm', 'class' => 'formStyle'));
    echo '<p>';
    echo $this->Form->input('to_user_name', array('label' => 'Za', 'readonly'=>TRUE, 'div' => FALSE));
    echo '<br>';
    echo $this->Form->input('subject', array('label' => 'Zadeva', 'style' => 'width: 450px;', 'div' => FALSE));
    echo '<br>';
    echo $this->Form->input('message', array('label' => 'Sporočilo', 'rows' => '7', 'style' => 'width: 450px;', 'div' => FALSE));
    echo '<br>';
    echo '<br>';

    echo $this->Form->hidden('to_user_id');
    echo $this->Form->hidden('from_user_id');
    echo $this->Form->hidden('read');
    echo $this->Form->hidden('parent_id');
    echo $this->Form->button('Pošlji', array('type' => 'submit'));
    echo '</p>';
    echo $this->Form->end();
?>
</div>