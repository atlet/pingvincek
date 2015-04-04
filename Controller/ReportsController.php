<?php

class ReportsController extends AppController
{

    var $name    = 'Reports';
    var $helpers = array('Html', 'Form');

    var $paginate = array
    (
        'order' => array
        (
            'Report.created' => 'desc'
        )    
    );

    function add($uid = NULL)
    {
        if (isset($this->request->data))
        {
            if ($this->Report->save($this->request->data))
            {
                echo "<script> $('#dialog-form').dialog('close'); </script>";
            }
        }

        if ($uid)
        {
            $this->set('uid', $uid);
            $this->request->data['Report']['user_id'] = $uid;
        }

        $this->request->data['Report']['reporter_user_id'] = $this->Auth->user('id');

        if ($this->RequestHandler->isAjax())
        {
            $this->layout = 'ajax';
        }
    }
    
    function admin_index()
    {
        $this->Report->recursive = 0;
        $this->set('reports', $this->paginate());
    }

}

?>