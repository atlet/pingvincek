<div class="span-19">
    <h1>Označite del slike, ki bo uporabljen za vaš profil</h1>

    <?php
    if (isset($javascript))
    {
       echo $javascript->link('jquery.imgareaselect.pack', FALSE);
    }

    echo $this->Form->create('User', array('action' => 'uw3'));

    echo $this->Html->image('upload/' . $profilePicName, array('id' => 'urediSliko', 'width' => $tmpWidth . 'px'));

    echo $this->Form->hidden('x1', array('id' => 'x1'));
    echo $this->Form->hidden('y1', array('id' => 'y1'));
    echo $this->Form->hidden('x2', array('id' => 'x2'));
    echo $this->Form->hidden('y2', array('id' => 'y2'));
    echo $this->Form->hidden('width', array('id' => 'width'));
    echo $this->Form->hidden('height', array('id' => 'height'));
    echo $this->Form->hidden('tmpImageName', array('value' => $profilePicName));
    echo $this->Form->hidden('tmpRatio', array('value' => $tmpRatio));

    echo "<br>";
    echo $this->Form->end('Shrani sliko');
    ?>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('img#urediSliko').imgAreaSelect({
        handles: true,
        aspectRatio: "1:1",
        minHeight: 15,
        minWidth: 15,
        persistent: true,
        show: true,
        x1: 0,
        y1: 0,
        x2: 100,
        y2: 100,
        onSelectEnd: function (img, selection) {
            $('#x1').val(selection.x1);
            $('#y1').val(selection.y1);
            $('#x2').val(selection.x2);
            $('#y2').val(selection.y2);
            $('#width').val(selection.width);
            $('#height').val(selection.height);
    }
    });
});
</script>