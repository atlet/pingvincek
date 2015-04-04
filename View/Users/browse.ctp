<?php if(!$isProfileOk): ?>
	<div class=" prepend-top"></div>
	<div class="span-17 prepend-1 last">
		<div class="notice">
			V kolikor želite videti profile drugih oseb, ter jim pošiljati zasebna sporočila, morate izpolniti vaš profil (sliko profila, ter opis o meni in iščem)!
		</div>
	</div>
<?php endif; ?>

<div class="span-19 last">
    <h1>Osebe v okolici</h1>
    <p></p>    
    <table class="tabelaProfili" border="0">
        <?php
        $i = 0;

        foreach ($users as $user):
            switch ($i % 3) {
                case 0:
                    echo "<tr>";
                    break;
                case 1:

                    break;
                case 2:

                    break;
                default:
                    break;
            }
            ?>

            <td>
                <div class="test slika">
                    <?php
                    if ($user['User']['picture_id'] == 0) {
                        echo $this->Html->link($this->Html->image('upr.png', array("class" => "slikaProfil")), '/users/view/' . $user['User']['id'], array('escape' => false));
                    } else {
                        $tmpPicture = explode('.', $user['Profilepicture']['picture']);
                        echo $this->Html->link($this->Html->image($user['Profilepicture']['directory'] . $tmpPicture[0] . '-s.' . $tmpPicture[1], array("class" => "slikaProfil")), '/users/view/' . $user['User']['id'], array('escape' => false));
                    }
                    ?>

                    <p class="imeProfil">
                        <?php
                        echo $this->Html->link($user['User']['nickName'], '/users/view/' . $user['User']['id']);
                        if (($user['User']['yearOld'])) {
                            echo ' (' . $user['User']['yearOld'] . ')';
                        }

                        if (($user['City']['name'])) {
                            echo '<br>' . $user['City']['name'];
                        } else {
                            echo '<br> &#8194;';
                        }
                        ?>
                    </p>
                </div>
            </td>

            <?php
            switch ($i % 3) {
                case 0:

                    break;
                case 1:

                    break;
                case 2:
                    echo "</tr>";
                    break;
                default:
                    break;
            }
            $i++;
            ?>
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