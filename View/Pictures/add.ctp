<div class="span-19">
    <h1>Naloži novo sliko</h1>
    <?php
    echo "<p>Na sliki morate biti obvezno vi, prav tako mora biti viden vaš obraz. <br>Ni povoljeno nalagati pornografskih slik!<br></p>";
    echo $this->Form->create('Picture', array('action' => 'add', 'type' => 'file'));
    echo '<fieldset>';
    echo '<legend>Slika</legend>';
    echo $this->Form->input('picture', array('type'=>'file', 'class' => 'text', 'class' => 'text', 'label' => 'Slika'));
    echo $this->Form->input('description', array('label' => 'Opis', 'class' => 'text'));
    echo $this->Form->button('Naloži', array('type' => 'submit'));
    echo $this->Form->end();
    echo '</fieldset>';
    ?>
</div>