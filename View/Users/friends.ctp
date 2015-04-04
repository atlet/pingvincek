<div class="span-19 last">
    <h1>Prijatelji</h1>
    <p></p>
    <?php

    $i = 0;
    foreach ($users as $user):
        $class = null;
        if ($i++ % 3 == 0)
        {
            $class = 'span-5 prepend-1 last"';
        }
        else
        {
            $class = 'span-5 prepend-1 last"';
        }
    ?>

        <div class="<?php echo $class; ?>">
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

            <p class="imeProfil"><?php echo $user['User']['nickName'] . ", " . $user['User']['yearOld'] . "<br>" . $user['City']['name'] . ", " . $user['0']['countryName']; ?></p>
        </div>
    </div>
    <?php endforeach; ?>
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