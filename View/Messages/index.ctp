<div class="span-19">
    <h1>Zasebna sporočila - prejeta</h1>

    <p>
        <?php
        echo $this->Html->link('Prejeto', '/messages/index');
        echo " | ";
        echo $this->Html->link('Poslano', '/messages/send');
        ?>
    </p>
    <table class="profili" cellspacing="0" cellpadding="0">
        <tr>
            <th></th>
            <th>Zadeva</th>
            <th>Od</th>
            <th>Prejeto</th>
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
                <td>
                    <?php
                    switch ($sporocilo['Message']['status'])
                    {
                        case 0:
                            //echo $this->Html->image('email.png', array('alt' => 'Novo'));
                            echo $this->Html->image('new.png', array('alt' => 'Novo'));
                            break;
                        case 1:
                            echo $this->Html->image('email_open.png', array('alt' => 'Prebrano'));
                            break;
                        case 2:
                            echo $this->Html->image('email_go.png', array('alt' => 'Odgovorjeno'));
                            break;
                    }
                    echo "</td> <td>";
                    if ($sporocilo['Message']['status'] == 0)
                    {
                        echo "<b>";
                    }
                    echo $this->Html->link($sporocilo['Message']['subject'], '/messages/view/' . $sporocilo['Message']['id']);
                    if ($sporocilo['Message']['status'] == 0)
                    {
                        echo "</b>";
                    }
                    ?>
                </td>
                <td><?php
                if ($sporocilo['Message']['status'] == 0)
                {
                    echo "<b>";
                }
                    ?><?php echo $this->Html->link($sporocilo['Fromuser']['nickName'], '/users/view/' . $sporocilo['Fromuser']['id']); ?><?php
                if ($sporocilo['Message']['status'] == 0)
                {
                    echo "</b>";
                }
                    ?></td>
                <td><?php
                if ($sporocilo['Message']['status'] == 0)
                {
                    echo "<b>";
                }
                    ?><?php echo $this->Time->format('H:i d.m.Y', $sporocilo['Message']['created']); ?><?php
                if ($sporocilo['Message']['status'] == 0)
                {
                    echo "</b>";
                }
                    ?></td>
                <td><?php
                if ($sporocilo['Message']['status'] == 0)
                {
                    echo "<b>";
                }
                ?><?php echo $this->Html->link('Odgovori', '/messages/reply/' . $sporocilo['Message']['id']) . " | " . $this->Html->link('Zbriši', '/messages/delete/' . $sporocilo['Message']['id']); ?><?php
                if ($sporocilo['Message']['status'] == 0)
                {
                    echo "</b>";
                }
                ?></td>
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