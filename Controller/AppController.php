<?php

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class AppController extends Controller {

    var $pageTitle = 'Zmenkarije';
    var $components = array('Session', 'RequestHandler',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'users', 'action' => 'browse', 'admin' => FALSE),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'index', 'admin' => FALSE),
            'authorize' => 'Controller',
            'scope' => array('User.ban' => FALSE),
            'authError' => 'Žal nimate dovoljenja za dostop do te lokacije!',
            'loginError' => "Uporabniško ime ali geslo je napačno.",
            'flashElement' => "flash_success",
            'autoRedirect' => false
            ));
    var $uses = array('Users', 'Config');
    var $helpers = array('Moj', 'Html', 'Session', 'Time', 'Js' => array('Jquery'));

    function beforeFilter() {
        if (isset($this->request->params['admin'])) {
            $this->layout = 'admin';
        }

        $this->set('title_for_layout', 'Pingvinček zasebni stiki');

        if ($this->Auth->loggedIn()) {
            $prijavljen = true;
            $this->loadModel('Message');
            $this->Message->recursive = -1;
            $this->set('tmpMessageCount', $this->Message->find('count', array('conditions' => array('Message.status' => 0, 'Message.to_user_id' => $this->Auth->User('id'), 'toUserDelete' => 0))));

            $this->loadModel('User');
            $tmpUserData = $this->User->findById($this->Auth->user('id'));
            if ($tmpUserData['User']['ban']) {
                $this->Session->setFlash(__('Zaradi sumljivih aktivnosti, ste bili začasno onemogočeni. Počakajte na navodila administratorja.'), 'flash_success');
                return $this->redirect($this->Auth->logout());
            }
        } else {
            $prijavljen = false;
        }

        $this->set('prijavljen', $prijavljen);
    }

    function isAuthorized($user = null) {
     if (isset($this->request->params['admin'])) { 
        if ($this->Auth->user('group_id') == 1) {
            return true;
        } else {
            return false;
        }
    }
    return true;
}

}

?>
