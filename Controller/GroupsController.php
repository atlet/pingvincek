<?php

class GroupsController extends AppController
{

    var $name = 'Groups';
    var $helpers = array('Html', 'Form');

    function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    function admin_index()
    {
        $this->Group->recursive = 0;
        $this->set('groups', $this->paginate());
    }

    function admin_view($id = null)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid Group.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('group', $this->Group->read(null, $id));
    }

    function admin_add()
    {
        if (!empty($this->request->data))
        {
            $this->Group->create();
            if ($this->Group->save($this->request->data))
            {
                $this->Session->setFlash(__('The Group has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The Group could not be saved. Please, try again.'));
            }
        }
    }

    function admin_edit($id = null)
    {
        if (!$id && empty($this->request->data))
        {
            $this->Session->setFlash(__('Invalid Group'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data))
        {
            if ($this->Group->save($this->request->data))
            {
                $this->Session->setFlash(__('The Group has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The Group could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data))
        {
            $this->request->data = $this->Group->read(null, $id);
        }
    }

    function admin_delete($id = null)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid id for Group'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Group->del($id))
        {
            $this->Session->setFlash(__('Group deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_security($id)
    {

        if (!empty($this->request->data))
        {

            // lets get the Aro i.e. the group
            $aro_foreign_key = $this->request->data['Group']['id'];

            $aro = new Aro();
            $aro_record = $aro->findByAlias('Group:' . $aro_foreign_key);

            $aro_alias = $aro_record['Aro']['alias'];
            $aco_of_aro = $aro_record['Aco'];

            // lets run through the security selection
            $sec_access = $this->request->data['Group']['SecurityAccess'];

            $aco = new Aco();
            $inflect = new Inflector();

            foreach ($sec_access as $aco_id => $access_type)
            {

                $aco_record = $aco->findById($aco_id);

                $model_plural = $inflect->pluralize($aco_record['Aco']['model']);

                if ($access_type == 'allow')
                {
                    $this->Acl->allow($aro_alias,
                            $model_plural . '/' . $aco_record['Aco']['alias'], '*');
                }
                elseif ($access_type == 'deny')
                {
                    $this->Acl->deny($aro_alias,
                            $model_plural . '/' . $aco_record['Aco']['alias'], '*');
                }
            }
        }

        if (empty($this->request->data))
        {
            $this->request->data = $this->Group->read(null, $id);
        }

        // lets gather the aco selections available
        $aco = new Aco();

        // list the whole tree
        $acoTree = $aco->generateTreeList();

        // now get the details of the Aco records
        $acoRecords = $aco->find('all');

        $this->set(compact('acoTree', 'acoRecords'));

        $this->set('current_alias', $this->Group->name . ':' . $this->Group->id);
    }

}
?>
