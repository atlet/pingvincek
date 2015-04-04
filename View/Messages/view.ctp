<?php
if (isset($javascript))
{
    echo $javascript->link('prototype', FALSE);
    echo $javascript->link('scriptaculous', FALSE);
    echo $javascript->link('lightbox', FALSE);
}
?>

<div class="span-19">
    <h1>Ogled sporočila</h1>
    <p>
        <?php
        echo $this->Html->link('Odgovori', '/messages/reply/' . $message['Message']['id']);
        ?>
    </p>

    <table class="profili" cellspacing="0" cellpadding="0">
        <tr>
            <th colspan="2"><?php echo $message['Message']['subject'] . " | " . $message['Fromuser']['nickName'] . " | " . $this->Time->format('H:i d.m.Y', $message['Message']['created']); ?></th>
        </tr>
        <tr>
            <td rowspan="2" style="width: 90px; vertical-align: top;">
                <?php
                if (!($message['Fromuser']['picture_id'] == 0))
                {
                    $tmpPicture = explode('.', $message['Fromuser']['Profilepicture']['picture']);
                    echo $this->Html->link($this->Html->image($message['Fromuser']['Profilepicture']['directory'] . $tmpPicture[0] . '-s.' . $tmpPicture[1]), '/users/view/' . $message['Fromuser']['id'], array('escape' => false));
                }
                else
                {
                    echo $this->Html->link($this->Html->image('upr.png'), '/users/view/' . $message['Fromuser']['id'], array('escape' => false));
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <?php echo nl2br($message['Message']['message']); ?>
            </td>
        </tr>
    </table>
</div>