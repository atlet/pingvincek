<div class="span-19">
    <h1>Pozabil sem geslo</h1>
    <p>
        Če ste pozabili geslo, vpišite v polje e-mail vaš elektronski naslov, ki ga uporabljate za prijavo na spletno stran in poslali vam bomo novega.
    </p>
    <br>
    <?php
    echo $this->Form->create('User', array('action' => 'recover'));
    echo "<p>";
    echo $this->Form->input('username', array('label' => 'Vaš e-mail', 'div' => false, 'class' => 'text', 'between' => '<br>'));
    echo "<br>";
    echo $this->Form->button('Pošlji novo geslo', array('type' => 'submit'));
    echo $this->Form->button('Počisti polja', array('type' => 'reset'));
    echo "</p>";
    echo $this->Form->end();
    ?>
</div>