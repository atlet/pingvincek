<div class="users index">
    <h2>Prijave neprimernih profilov</h2>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
        ));
        ?></p>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('message'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
        </tr>
        <?php
        $i       = 0;
        foreach ($reports as $report):
            $class = null;
            if ($i++ % 2 == 0)
            {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <?php echo $this->Html->link($report['Report']['user_id'], array('controller' => 'users', 'action' => 'view', $report['Report']['user_id'], 'admin' => FALSE)); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($report['Report']['message'], array('action' => 'view', $report['Report']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Time->format($format  = 'H:i:s d-m-Y', $report['Report']['created']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        <?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>
