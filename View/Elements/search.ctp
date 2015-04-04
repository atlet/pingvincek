<div class="obroba">
    <h3>Filter</h3>
    <?php
    $tmpYears = array();

    for ($i = 18; $i < 100; $i++)
    {
        $tmpYears[$i] = $i;
    }

    echo $this->Form->create('user', array('action' => 'browse', 'class' => 'formStyle'));
    echo "<p>";
    echo $this->Form->input('genders', array('label' => 'Spol', 'empty' => '', 'div' => false));
    echo "<br>";
    echo $this->Form->input('distance', array('label' => 'Razdalja', 'empty' => '', 'after' => ' km', 'div' => false, 'style' => 'width: 70px;', 'options' => array('5' => '5', '25' => '25', '50' => '50', '100' => '100', '500' => 'Cela Slovenija'), 'empty' => ''));
    echo "<br>";
    echo $this->Form->input('ageFrom', array('label' => 'Starost od', 'empty' => '', 'options' => $tmpYears, 'empty' => '', 'div' => false));
    echo $this->Form->input('ageTo', array('label' => 'Starost do', 'empty' => '', 'options' => $tmpYears, 'empty' => '', 'div' => false));
    echo "<center>" . $this->Form->button('Išči', array('type' => 'submit')) . "</center>";
    echo $this->Form->end();
    echo "<p>";
    ?>
</div>