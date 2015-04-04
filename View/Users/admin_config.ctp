<div class="nastavitve form">
    <?php echo $this->Form->create(null, array('url' => array('controller' => 'users', 'action' => 'config', 'admin' => true))); ?>
    <fieldset>
        <legend>Privzete nastavitve</legend>
        <?php
        echo $this->Form->input('Privzete.email', array('label' => 'E-mail'));
        echo $this->Form->input('Privzete.skupina', array('label' => 'Skupina ob prijavi'));
        echo $this->Form->input('Privzete.wwwNaslov', array('label' => 'www naslov strani'));
        ?>
    </fieldset>
    <?php echo $this->Form->end('Shrani spremembe'); ?>
</div>