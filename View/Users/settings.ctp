<div class="span-19">
    <h1>Sprememba gesla</h1>

<?php
    echo $this->Form->create('User', array('action' => 'settings', 'class' => 'formStyle'));
    echo '<p>';
    echo $this->Form->input('id');
    echo $this->Form->input('oldp', array('label' => 'Staro geslo', 'type' => 'password', 'div' => FALSE));
    echo '<br>';
    echo $this->Form->input('newp1', array('label' => 'Novo geslo', 'type' => 'password', 'div' => FALSE));
    echo '<br>';
    echo $this->Form->input('newp2', array('label' => 'Ponovno vnesite geslo', 'type' => 'password', 'div' => FALSE));
    echo '<br>';
    echo $this->Form->button('Spremeni geslo', array('type' => 'submit'));
    echo $this->Form->button('Počisti polja', array('type' => 'reset'));
    echo $this->Form->end();
    echo '</p>';

    echo '<br>';

    echo $this->Form->create('User', array('class' => 'formStyleR', 'action' => 'settingschange'));
    echo "<p>";
    echo "<FIELDSET><LEGEND ACCESSKEY=I>Nastavitve zasebosti</LEGEND>";
    echo $this->Form->input('id');
    echo $this->Form->input('sendmails', array('label' => 'Želim prejeti e-mail, ko dobim novo privatno sporočilo.', 'div' => false));
    echo '<br>';
    echo '<br>';
    echo $this->Form->button('Shrani nastavitve', array('type' => 'submit'));
    echo $this->Form->end();
    echo "</fieldset>";
    echo '</p>';
?>
</div>