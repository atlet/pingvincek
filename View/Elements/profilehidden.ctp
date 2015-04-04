<div class="span-19">
    <h1><?php echo $user['User']['nickName']; ?></h1>

    <br>

    <div class="span-5 prepend-1">
        <div class="test">
            <?php
            if (!empty($user['User']['picture']))
            {
                echo $this->Html->link($this->Html->image('profilePictures/' . $user['User']['picture'], array("class" => "slikaProfil")),
                        '/users/view/' . $user['User']['id'], array('escape' => false));
            }
            else
            {
                echo $this->Html->link($this->Html->image('upr.png', array("class" => "slikaProfil")),
                        '/users/view/' . $user['User']['id'], array('escape' => false));
            }
            ?>
        </div>

    </div>

    <div class="span-11 prepend-1 append-1 last">
        <div class="test">
            <p>
                <?php echo $this->Html->link('Pošlji sporočilo', '/messages/newm/' . $user['User']['id']); ?> | <?php echo $this->Html->link('Dodaj med prijatelje', '/users/requestFriendships/' . $user['User']['id']); ?> | Prijavi neprimeren profil
            </p>
        </div>
    </div>

    <div class="span-11 prepend-1 append-1 last">
        <div class="test">
            <p>Profil je viden samo prijateljem!</p>
        </div>
    </div>

</div>