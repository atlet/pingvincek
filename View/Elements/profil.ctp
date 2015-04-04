<div class="span-19">
    <h1><?php echo $user['User']['nickName'] . ', ' . $user['User']['yearOld'] . ' let'; ?></h1>

    <br>

    <div class="span-5 prepend-1">
        <div class="test slika">
            <?php
            if ($user['User']['picture_id'] == 0) {
                echo $this->Html->link($this->Html->image('upr.png', array("class" => "slikaProfil")), '/users/view/' . $user['User']['id'], array('escape' => false));
            } else {
                $tmpPicture = explode('.', $user['Profilepicture']['picture']);
                echo $this->Html->link($this->Html->image($user['Profilepicture']['directory'] . $tmpPicture[0] . '-s.' . $tmpPicture[1], array("class" => "slikaProfil")), '/img/' . $user['Profilepicture']['directory'] . $user['Profilepicture']['picture'], array('escape' => false, 'class' => 'lightboxp'));
            }

            echo '<p><center>';
            if (!empty($user['Gender']['title'])) {
                echo $user['Gender']['title'] . '<br>';
            }

            echo 'Iz: ' . $user['City']['name'];
            echo '</center></p>';
            ?>
        </div>

    </div>

    <div class="span-11 prepend-1 append-1 last">
        <div class="test">
            <p>
                <?php echo $this->Html->link('Pošlji sporočilo', '/messages/newm/' . $user['User']['id']); ?> | <?php echo $this->Html->link('Dodaj med priljubljene', '/users/addToFavorites/' . $user['User']['id']); ?> | <?php echo $this->Html->link('Prijavi neprimeren profil', '', array('id' => 'jsNeprimerenProfil')); ?>
            </p>
        </div>
    </div>

    <div class="span-11 prepend-1 append-1 last">
        <div class="test">         
            <?php
            if (!empty($user['User']['aboutme'])) {
                ?> 
                <div class="span-3"><p><b>O meni</b></p></div>
                <div class="span-7 last"><p><?php echo nl2br($user['User']['aboutme']); ?></p></div>
                <?php
            }
            if (!empty($user['User']['whywritetome'])) {
                ?>     
                <div class="span-3"><p><b>Iščem</b></p></div>
                <div class="span-7 last"><p><?php echo nl2br($user['User']['whywritetome']); ?></p></div>             
            <?php } ?>
            <div style="clear: both;"></div>
        </div>
    </div>

    <div class="first span-17">

    </div>

    <?php
    $i = 1;
    foreach ($user['Picture'] as $picture):
        $class = null;
        switch ($i % 3) {
            case 0:
                $class = 'span-5 prepend-1 last"';
                break;
            case 1:
                $class = 'span-5 prepend-1"';
                break;
            case 2:
                $class = 'span-5 prepend-1"';
                break;
            default:
                break;
        }
        $i++;
        ?>

        <div class="<?php echo $class; ?>">
            <div class="test slika">
                <?php
                $tmpPicture = explode('.', $picture['picture']);
                echo $this->Html->link($this->Html->image($picture['directory'] . $tmpPicture[0] . '-s.' . $tmpPicture[1], array("class" => "slikaProfil")), '/img/' . $picture['directory'] . $picture['picture'], array('class' => 'lightbox', 'escape' => false));
                ?>

                <p class="imeProfil">
                    <?php
                    echo $picture['description'];
                    ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="dialog-form">
    <div id="tmpForm"></div>
</div>

<script type="text/javascript">
    $.ajaxSetup({cache: false});

    $(document).ready(function()
    {

        $(function()
        {
            $("#dialog-form").dialog(
                    {
                        height: 470,
                        autoOpen: false,
                        width: 470,
                        modal: true,
                        buttons:
                                {
                                    "Prekliči": function()
                                    {
                                        $(this).dialog("close");
                                    },
                                    "Prijavi": function()
                                    {
                                        $('#dodajBTN').click();
                                    }
                                }
                    });

            $('a.lightbox').lightBox();
            $('a.lightboxp').lightBox();

            $("#jsNeprimerenProfil").click(function() {
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'add', $user['User']['id'])); ?>/",
                    success: function(data) {
                        $("#dialog-form").dialog('open');
                        $("#dialog-form").dialog("option", "title", 'Prijavi neprimeren profil');
                        $("#tmpForm").html(data);
                    }
                });
                return false;
            });
        });
    });
</script>
