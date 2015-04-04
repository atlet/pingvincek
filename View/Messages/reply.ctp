<div class="span-19">
    <h1>Odgovori na sporočilo</h1>

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
    <br>
    <br>
    

<?php
    echo $this->Form->create('Message', array('action' => 'reply', 'class' => 'formStyle'));
    echo '<p>';
    echo $this->Form->input('to_user_name', array('label' => 'Za', 'readonly'=>TRUE, 'div' => FALSE));
    echo "<br>";
    echo $this->Form->input('subject', array('label' => 'Zadeva', 'style' => 'width: 450px;', 'div' => FALSE));
    echo "<br>";
    echo $this->Form->input('message', array('label' => 'Sporočilo', 'rows' => '7', 'style' => 'width: 450px;', 'div' => FALSE));
    echo "<br>";
    echo $this->Form->hidden('to_user_id');
    echo $this->Form->hidden('from_user_id');
    echo $this->Form->hidden('read');
    echo $this->Form->hidden('parent_id');
    echo $this->Form->hidden('mid');
    echo $this->Form->button('Pošlji', array('type' => 'submit'));
    echo $this->Form->end();
    echo '</p>';
?>
</div>