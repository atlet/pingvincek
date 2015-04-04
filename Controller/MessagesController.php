<?php

class MessagesController extends AppController {

    var $name = 'Messages';
    var $helpers = array('Html', 'Form', 'Time', 'Js');
    var $components = array('Email');
    var $uses = array('Message');

    function beforeFilter() {
        parent::beforeFilter();
    }

    function index() {
        $this->Message->recursive = -1;

        $this->paginate = array(
            'limit' => 20,
            'contain' => array('Fromuser.nickName'),
            'conditions' => array('Message.to_user_id' => $this->Auth->User('id'), 'toUserDelete' => 0),
            'fields' => array('id', 'created', 'subject', 'status'),
            'order' => array('Message.created DESC')
        );

        $this->set('messages', $this->paginate('Message'));
    }

    function send() {
        $this->Message->recursive = -1;

        $this->paginate = array(
            'limit' => 20,
            'contain' => array('Touser.nickName'),
            'conditions' => array('Message.from_user_id' => $this->Auth->User('id'), 'fromUserDelete' => 0),
            'fields' => array('id', 'created', 'subject', 'status'),
            'order' => array('Message.created DESC')
        );

        $this->set('messages', $this->paginate('Message'));

        //$this->request->data = $this->Message->find('all', array('contain' => array('Touser'), 'conditions' => array('Message.from_user_id' => $this->Auth->User('id'), 'fromUserDelete' => 0), 'order' => array('Message.created DESC')));
    }

    function view($messageID = NULL) {
        $this->Message->recursive = -1;
        $message = $this->Message->find('first', array('contain' => array('Touser', 'Fromuser', 'Fromuser.Profilepicture'), 'conditions' => array('Message.id' => $messageID)));
        $this->set('message', $message);

        if ($message['Message']['to_user_id'] == $this->Auth->User('id')) {
            $this->Message->spremeniStatus($messageID, 1);
        }

        if ((($message['Message']['to_user_id'] == $this->Auth->User('id')) OR ($message['Message']['from_user_id'] == $this->Auth->User('id'))) == FALSE) {
            $this->Session->setFlash(__('Tako se pa ne dela!'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }

    function newm($userID = NULL) {
        $this->User->recursive = -1;
        if (!$this->User->isProfileOk($this->Auth->user('id'))) {
            $this->Session->setFlash(__('V kolikor želite pošiljati sporočila, morate izpolniti profil (sliko profila, o meni ter iščem)!'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }

        if ($this->request->is('post')) {
            // Zbriši sporočilo, če zaznaš, da je "Spam" in ga označi kot spam.

            preg_match_all('/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i', $this->request->data['Message']['message'], $matches);

            $tmpStMailov = 0;
            $tmpPosljiMail = 1;

            foreach ($matches[0] as $email) {
                $tmpStMailov++;
            }

            if ($tmpStMailov > 0) {
                $this->request->data['Message']['toUserDelete'] = 1;
                $this->request->data['Message']['spam'] = 1;
                $tmpPosljiMail = 0;
            }

            if ($this->Message->save($this->request->data)) {
                // Blokiraj uporanika, če pošlje 3 sporočila v roku 2h minut.
                //if ($this->Message->find('count', array('conditions' => array('from_user_id' => $this->Auth->User('id'), "created >" => date( 'Y-m-d H:i:s', strtotime("-2 minutes") )))) >= 3)
                //{
                //    $this->Message->Fromuser->updateAll(array('ban' => 1, 'hideprofile' => 1), array('id' => $this->Auth->User('id')));
                //}

                $this->Message->Touser->recursive = -1;
                $tmpUser = $this->Message->Touser->findById($this->request->data['Message']['to_user_id'], array('Touser.username', 'Touser.sendmails'));

                if ($tmpUser['Touser']['sendmails'] && $tmpPosljiMail) {
                    $this->Email->to = $tmpUser['Touser']['username'];
                    $this->Email->from = $this->Config->get('email');
                    $this->Email->subject = $this->Auth->User('nickName') . ' ti je poslal novo privatno sporočilo na ' . $this->Config->get('wwwNaslov');
                    $this->Email->template = 'newMessage';
                    $this->Email->sendAs = 'text';
                    $this->set('tmpNickName', $this->Auth->User('nickName'));
                    $this->set('tmpWWW', $this->Config->get('wwwNaslov'));
                    $this->Email->send();
                }

                $this->Session->setFlash(__('Sporočilo je bilo uspešno poslano!'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Prosim, popravite napake!'), 'flash_success');
            }
        }

        if (isset($userID)) {
            $toUserData = $this->Message->Touser->findById($userID);
            $this->request->data['Message']['to_user_id'] = $toUserData['Touser']['id'];
            $this->request->data['Message']['to_user_name'] = $toUserData['Touser']['nickName'];
            $this->request->data['Message']['from_user_id'] = $this->Auth->User('id');
            $this->request->data['Message']['read'] = 0;
            $this->request->data['Message']['parent_id'] = 0;
            if ($this->request->data['Message']['to_user_id'] == $this->Auth->User('id')) {
                $this->Session->setFlash(__('Sam sebi ne moreš poslati sporočila. :)'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function reply($messageID = NULL) {
        $this->Message->recursive = -1;
        $message = $this->Message->find('first', array('contain' => array('Touser', 'Fromuser', 'Fromuser.Profilepicture'), 'conditions' => array('Message.id' => $messageID)));
        $this->set('message', $message);

        if (isset($this->request->data)) {
            $mid = $this->request->data['Message']['mid'];
            if ($this->Message->save($this->request->data)) {
                $this->Message->Touser->recursive = -1;
                $tmpUser = $this->Message->Touser->findById($this->request->data['Message']['to_user_id'], array('Touser.username', 'Touser.sendmails'));

                if ($tmpUser['Touser']['sendmails']) {
                    $this->Email->to = $tmpUser['Touser']['username'];
                    $this->Email->from = $this->Config->get('email');
                    $this->Email->subject = $this->Auth->User('nickName') . ' je odgovoril na privatno sporočilo na ' . $this->Config->get('wwwNaslov');
                    $this->Email->template = 'messageReply';
                    $this->Email->sendAs = 'text';
                    $this->set('tmpNickName', $this->Auth->User('nickName'));
                    $this->set('tmpWWW', $this->Config->get('wwwNaslov'));
                    $this->Email->send();
                }

                $this->Message->spremeniStatus($mid, 2);
                $this->Session->setFlash(__('Sporočilo je bilo uspešno poslano!'), 'flash_success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Prosim, popravite napake!'), 'flash_success');
            }
        }

        if (isset($messageID)) {
            $toMessageData = $this->Message->findById($messageID);
            $fromUserTmp = $this->Message->read('from_user_id', $messageID);
            $this->Message->Touser->recursive = -1;
            $toUserData = $this->Message->Touser->findById($fromUserTmp['Message']['from_user_id']);
            $parentIdTmp = $this->Message->read('parent_id', $messageID);
            if ($parentIdTmp['Message']['parent_id'] == 0) {
                $parentIdTmp = $messageID;
            } else {
                $parentIdTmp = $parentIdTmp['Message']['parent_id'];
            }
            $this->request->data['Message']['to_user_id'] = $fromUserTmp['Message']['from_user_id'];
            $this->request->data['Message']['to_user_name'] = $toUserData['Touser']['nickName'];
            $this->request->data['Message']['subject'] = "Odg: " . str_replace("Odg: ", "", $toMessageData['Message']['subject']);
            $this->request->data['Message']['from_user_id'] = $this->Auth->User('id');
            $this->request->data['Message']['read'] = 0;
            $this->request->data['Message']['parent_id'] = $parentIdTmp;
            $this->request->data['Message']['mid'] = $messageID;
        } else {
            $this->Session->setFlash(__('Tako se pa ne dela!'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }

        if ($this->request->data['Message']['to_user_id'] == $this->Auth->User('id')) {
            $this->Session->setFlash(__('Sam sebi ne moreš poslati sporočila. :)'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }

        if ((($message['Message']['to_user_id'] == $this->Auth->User('id')) OR ($message['Message']['from_user_id'] == $this->Auth->User('id'))) == FALSE) {
            $this->Session->setFlash(__('Tako se pa ne dela!'), 'flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }

    function delete($id = NULL) {
        $this->Message->deleteMessage($id, $this->Auth->User('id'));
        $this->Session->setFlash(__('Sporočilo je bilo uspešno zbrisano!'), 'flash_success');
        $this->redirect(array('action' => 'index'));
    }

}

?>