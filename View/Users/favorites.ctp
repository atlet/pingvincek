<div class="span-19 last">
    <h1>Priljubljene osebe</h1>
    <p></p>  

    <?php
    $i = 0;
//debug($favorites);
    foreach ($favorites as $user):
        $class = null;
        switch ($i % 3)
        {
            case 0:
                $class = 'span-5 prepend-1';
                break;
            case 1:
                $class = 'span-5 prepend-1';
                break;
            case 2:
                $class = 'prepend-1 span-5 last';
                break;
            default:
                break;
        }
        $i++;
        ?>

        <div class="<?php echo $class; ?>">
            <div class="test">
                <?php
                if ($user['Favoritep']['picture_id'] == 0)
                {
                    echo $this->Html->link($this->Html->image('upr.png', array("class" => "slikaProfil")), '/users/view/' . $user['Favoritep']['id'], array('escape' => false));
                }
                else
                {
                    $tmpPicture = explode('.', $user['Favoritep']['Profilepicture']['picture']);
                    echo $this->Html->link($this->Html->image($user['Favoritep']['Profilepicture']['directory'] . $tmpPicture[0] . '-s.' . $tmpPicture[1], array("class" => "slikaProfil")), '/users/view/' . $user['Favoritep']['id'], array('escape' => false));
                }
                ?>

                <p class="imeProfil">
                    <?php
                    echo $this->Html->link($user['Favoritep']['nickName'], '/users/view/' . $user['Favoritep']['id']);
                    if (($user['Favoritep']['yearOld']))
                    {
                        echo ' (' . $user['Favoritep']['yearOld'] . ')';
                    }

                    if (isset($user['Favoritep']['City']['name']))
                    {
                        echo '<br>' . $user['Favoritep']['City']['name'];
                    }
                    else
                    {
                        echo '<br> &#8194;';
                    }
                    
                    echo '<br>' . $this->Html->link('Odstrani iz priljubljenih', array('controller' => 'users', 'action' => 'removeFromFavorites', $user['Favorite']['id']));
                    ?> 
                </p>
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