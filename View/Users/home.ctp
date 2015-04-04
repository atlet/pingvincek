<div class="span-19">
    <h1>Neprebrana sporočila</h1>

    <p>
    <table cellspacing="0" cellpadding="0">
        <tr>
            <th></th>
            <th>Zadeva</th>
            <th>Od</th>
            <th>Prejeto</th>
            <th>Možnosti</th>
        </tr>
        <?php
        $i = 0;
        foreach ($sporocila as $sporocilo):
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
                        echo $this->Html->image('email.png', array('alt' => 'Novo'));
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
                if ($sporocilo['Message']['subject'] == 0)
                {
                    echo "</b>";
                }
                ?></td>
            <td><?php echo $this->Html->link($sporocilo['Fromuser']['nickName'], '/users/view/' . $sporocilo['Fromuser']['id']); ?></td>
            <td><?php echo $this->Time->format('H:i d.m.Y', $sporocilo['Message']['created']); ?></td>
            <td><?php echo $this->Html->link('Odgovori', '/messages/reply/' . $sporocilo['Message']['id']) . " | " . $this->Html->link('Zbriši', '/messages/delete/' . $sporocilo['Message']['id']); ?></td>
        </tr>
        <?php endforeach; ?>
            </table>
        </p>

</div>