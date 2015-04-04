<div class="groups security">
<h3>Group Security</h3>

This page allows you to control the access rights for the selected group.



<table cellpadding="0" cellspacing="0">

    <?php
    echo $this->Form->create(array('url' => '/admin/groups/security/' . $this->request->data['Group']['id']));

    foreach ($acoTree as $item)
    {

        // id
        $aco_id = str_replace("_", "", $item);

        // record details
        $acoRecord = array();
        $selected = '';

        foreach ($acoRecords as $aco)
        {

            if ($aco['Aco']['id'] == $aco_id)
            {
                $acoRecord = $aco;

                // check whether its been selected
                $aroRecords = $aco['Aro'];

                foreach ($aroRecords as $aro)
                {

                    if ($aro['alias'] == $current_alias)
                    {

                        if (( $aro['Permission']['_create'] == 1 ) &&
                                ( $aro['Permission']['_read'] == 1 ) &&
                                ( $aro['Permission']['_update'] == 1 ) &&
                                ( $aro['Permission']['_delete'] == 1 )
                        )
                        {
                            $selected = 'allow';
                            break;
                        }
                        else
                        {
                            $selected = 'deny';
                            break;
                        }
                    }
                }

                break;
            }
        }

        // levels
        $pattern = '/_/';
        $matches = preg_match($pattern, $item);

        //echo str_repeat( '&nbsp;', $matches*3 );
        echo "<tr>";
        //echo "<td style=\"text-align:left\">" . $acoRecord['Aco']['model'] . ' : ' . $acoRecord['Aco']['alias'] . "</td>";
        //echo $acoRecord['Aco']['model'].' : '.$acoRecord['Aco']['alias'];
        //echo '&nbsp;';

        $inflect = new Inflector();
        if ($inflect->pluralize($acoRecord['Aco']['model']) != $acoRecord['Aco']['alias'])
        {
            echo "<td style=\"text-align:left\">" . $acoRecord['Aco']['model'] . ' : ' . $acoRecord['Aco']['alias'] . "</td>";

            echo "<td>" . $this->Form->radio('Group.SecurityAccess.' . $aco_id,
                    array('allow' => '&nbsp;Allow',
                        'deny' => '&nbsp;Deny'),
                    array('default' => $selected,
                        'legend' => false
                    )
            ) . "</td>";
        }
        else
        {
            echo "<th style=\"text-align:left\">" . $acoRecord['Aco']['model'] . ' : ' . $acoRecord['Aco']['alias'] . "</th>";
            echo "<th></th>";
        }
        echo "</tr>";
    }

    echo "</table>";
    echo $this->Form->hidden('Group.id', array($this->request->data['Group']['id']));

    echo $this->Form->end(array('label' => 'Shrani spremembe', 'div' => false));
    ?>


</div>

<div class="actions">
    <ul>
        <li><?php echo $this->Html->link('Spisek skupin', array('controller' => 'groups', 'action' => 'index', 'admin' => TRUE)); ?></li>
    </ul>
</div>