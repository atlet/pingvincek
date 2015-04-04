<div class="obroba clearfix">
    <h3>Osebni meni</h3>
    <ul id="menuL">
        <li><?php echo $this->Html->link('Ogled profila', '/users/view'); ?></li>
        <li><?php echo $this->Html->link('Moje slike', array('controller' => 'pictures', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Urejanje profila', '/users/edit'); ?></li>
        <li><?php echo $this->Html->link('Nastavitve', '/users/settings'); ?></li>
        <li><?php echo $this->Html->link('Odjava', '/users/logout'); ?></li>
    </ul>
    <p></p>
</div>