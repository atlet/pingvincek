<div class="span-19">
    <h1>Slika profila</h1>
    <p>
        <?php
        if (isset($user['User']['picture']) && $user['User']['picture'] != NULL)
        {
            echo $this->Html->image('profilePictures/' . $user['User']['picture']);
        }
        else
        {
            echo $this->Html->image('upr.png');
        }

        echo '<br><br>' . $this->Html->link('Dodaj sliko profila', '/users/uw1');
        echo ' | ' . $this->Html->link('Odstrani sliko profila', '/users/removepicture', array(), 'Ali ste prepričani, da želite odstraniti sliko profila?');
        ?>
    </p>
</div>