<?php

App::uses('AppController', 'Controller');

class ArticlesController extends AppController
{

    var $name = 'Articles';
    var $helpers = array('Html', 'Form', 'Time');

    function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view');
    }

    // Izpisem vse članke!
    function index()
    {
        $this->set('title_for_layout', 'Članki o spletnih zmenkarijah ter ostalih zanimivostih');
        $this->Article->recursive = -1;
        $this->set('articles', $this->Article->find('all', array('conditions' => array('Article.published' => 1, 'Article.start <=' => date('Y-m-d')), 'order' => array('Article.created DESC'), 'fields' => array('Article.slug', 'Article.title', 'Article.created'))));
    }

    function view($slug = NULL)
    {
        if (!$slug)
        {
            $this->redirect(array('action' => 'index'));
        }

        $article = $this->Article->findBySlug($slug);
        
        $this->set('title_for_layout', $article['Article']['title'] . ' | Pingvinček zasebni stiki');

        $this->Article->read(null, $article['Article']['id']);
        $tmpCount = $article['Article']['views'] + 1;
        $this->Article->set('views', $tmpCount);
        $this->Article->save(array(), TRUE, array('views'));

        $this->set('article', $article);
    }

    function admin_index()
    {
        $this->Article->recursive = 0;
        $this->set('articles', $this->paginate());
    }

    function admin_form($id = NULL)
    {
        if (!empty($this->request->data))
        {
            if (!isset($this->request->data['Article']['id']))
            {
                $this->Article->create();
            }

            if ($this->Article->save($this->request->data))
            {
                $this->Session->setFlash(__('Članek je bil uspešno shranjen.'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('Prosim, popravite napake!'));
            }
        }

        if ($id && empty($this->request->data))
        {
            $this->request->data = $this->Article->read(null, $id);
        }
    }

}

?>
