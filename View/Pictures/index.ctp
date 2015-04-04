<div class="span-19 last">
    <h1>Slike</h1>
    <p>
        <?php echo $this->Html->link('Naloži novo sliko', array('controller' => 'pictures', 'action' => 'add')); ?>
    </p>
    <?php
    $i = 1;
    foreach ($pictures as $picture):
        $class = null;
        switch ($i % 3)
        {
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
                    $tmpPicture = explode('.', $picture['Picture']['picture']);
                    echo $this->Html->link($this->Html->image($picture['Picture']['directory'] . $tmpPicture[0] . '-s.' . $tmpPicture[1], array("class" => "slikaProfil")), '/img/' . $picture['Picture']['directory'] . $picture['Picture']['picture'], array('escape' => false, 'class' => 'lightbox'));
                ?>

                <p class="imeProfil">
                    <?php 
                        echo $picture['Picture']['description']; 
                        echo '<br><br>';
                        echo $this->Html->link('Kot profilna slika', array('controller' => 'pictures', 'action' => 'setasprofilepicture', $picture['Picture']['id']));
                        echo ' | ';
                        echo $this->Html->link('Zbriši', array('controller' => 'pictures', 'action' => 'delete', $picture['Picture']['id']));
                    ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
$(function() {
        $('a.lightbox').lightBox();
});
</script>