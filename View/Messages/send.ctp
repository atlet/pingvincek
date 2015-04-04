<div class="span-19">
    <h1>Zasebna sporočila - poslana</h1>
<p>
    <?php
    echo $this->Html->link('Prejeto', '/messages/index');
    echo " | ";
    echo $this->Html->link('Poslano', '/messages/send');
    ?>
</p>
    <table class="profili" cellspacing="0" cellpadding="0">
        <tr>
            <th>Zadeva</th>
            <th>Za</th>
            <th>Poslano</th>
            <th>Možnosti</th>
        </tr>
        <?php
        $i = 0;
        foreach ($messages as $sporocilo):
            $class = null;
            if ($i++ % 2 == 0)
            {
                $class = ' class="altrow"';
            }
        ?>
            <tr>
                <td><?php echo $this->Html->link($sporocilo['Message']['subject'], '/messages/view/' . $sporocilo['Message']['id']); ?></td>
                <td><?php echo $this->Html->link($sporocilo['Touser']['nickName'], '/users/view/' . $sporocilo['Touser']['id']); ?></td>
                <td><?php echo $this->Time->format('H:i d.m.Y', $sporocilo['Message']['created']); ?></td>
                <td><?php echo $this->Html->link('Zbriši', '/messages/delete/' . $sporocilo['Message']['id']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="span-19 last">
    <p>
        <?php
        echo $this->Paginator->prev('<< Prejšnja ', null, null, array('class' => 'disabled'));
        echo $this->Paginator->numbers();
        echo $this->Paginator->next(' Naslednja >>', null, null, array('class' => 'disabled'));
        ?>
    </p>
</div>