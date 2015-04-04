<div class="span-19">
    <h1>Urejanje profila</h1>


    <?php
    $this->Html->script('regions.js', array('inline' => FALSE));
    echo $this->Form->create('User', array('class' => 'formStyle'));
    echo "<p>";
    echo "<FIELDSET><LEGEND ACCESSKEY=I>Osnovni podatki</LEGEND>";
    echo $this->Form->input('id');

    echo $this->Form->input('User.nickName', array('label' => 'Vzdevek', 'div'   => false, 'error' => false));
    echo $this->Form->error('User.nickName', null, array('wrap'  => 'em', 'class' => 'error-message'));
    echo "<br>";

    echo $this->Form->input('gender_id', array('label' => 'Spol'));
    echo $this->Form->input('birthdate', array('label'      => 'Rojstni datum', 'minYear'    => '1910', 'dateFormat' => 'DMY', 'maxYear'    => date("Y")));
    echo $this->Form->input('User.city_id', array('label' => 'Mesto/kraj', 'empty' => ''));
    echo "</fieldset>";


    echo "<FIELDSET><LEGEND ACCESSKEY=I>O meni</LEGEND>";
    echo $this->Form->input('aboutme', array('label' => 'O meni'));
    echo $this->Form->input('whywritetome', array('label' => 'Iščem'));

    echo $this->Form->button('Pošlji', array('type' => 'submit'));
    echo $this->Form->end();
    echo "</fieldset>";
    echo "</p>";
    ?>   

</div>