<div class="span-19">
    <h1>Naloži sliko</h1>
    <p>
        <?php
        echo "<p>Naložite sliko, ki jo želite imeti za sliko profila<br>
    Na sliki morate biti obvezno vi, prav tako mora biti viden vaš obraz.<br></p>";
        echo $this->Form->create('User', array('action' => 'uw2', 'type' => 'file'));
        echo '<p>';
        echo $this->Form->file('image', array('label' => 'Slika', 'div' => FALSE));
        echo "<br><br>";
        echo $this->Form->button('Naloži', array('type' => 'submit'));
        echo $this->Form->end();
        echo '</p>';
        ?>
    </p>
</div>