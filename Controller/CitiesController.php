<?php

class CitiesController extends AppController
{

    var $name    = 'Cities';
    var $helpers = array('Html', 'Form');

    function admin_index()
    {
        $this->City->recursive = 0;
        $this->set('cities', $this->paginate());
    }

    function admin_view($id = null)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid City.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('city', $this->City->read(null, $id));
    }

    function admin_add()
    {
        if (!empty($this->request->data))
        {
            $this->City->create();
            if ($this->City->save($this->request->data))
            {
                $this->Session->setFlash(__('The City has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The City could not be saved. Please, try again.'));
            }
        }
    }

    function admin_edit($id = null)
    {
        if (!$id && empty($this->request->data))
        {
            $this->Session->setFlash(__('Invalid City'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data))
        {
            if ($this->City->save($this->request->data))
            {
                $this->Session->setFlash(__('The City has been saved'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The City could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data))
        {
            $this->request->data = $this->City->read(null, $id);
        }
    }

    function admin_delete($id = null)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid id for City'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->City->del($id))
        {
            $this->Session->setFlash(__('City deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }

}

?>