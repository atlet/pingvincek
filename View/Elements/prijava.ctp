<div class="obroba">
    <h3>Prijava</h3>
    <?php
    echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login')));
    echo "<p>";
    echo $this->Form->input('User.username', array('label' => 'E-mail:', 'div' => false, 'error' => false));
    echo $this->Form->input('User.password', array('label' => 'Geslo:', 'div' => false, 'error' => false));
    echo "<br><center>" . $this->Form->end('Prijava') . "</center>";
    echo "<p>";
    ?>

    <center>
        <?php 
            echo $this->Html->link('Pozabil sem geslo', array('controller' => 'users', 'action' => 'recover')); 
            echo '<br>';
            echo $this->Html->link('Ustvari nov račun', array('controller' => 'users', 'action' => 'register')); 
        ?>
    </center>
</form>
<p></p>
</div>