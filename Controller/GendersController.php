<?php
class GendersController extends AppController {

	var $name = 'Genders';
	var $helpers = array('Html', 'Form');

	function admin_index() {
		$this->Gender->recursive = 0;
		$this->set('genders', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Gender.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('gender', $this->Gender->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->Gender->create();
			if ($this->Gender->save($this->request->data)) {
				$this->Session->setFlash(__('The Gender has been saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Gender could not be saved. Please, try again.'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Gender'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Gender->save($this->request->data)) {
				$this->Session->setFlash(__('The Gender has been saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Gender could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Gender->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Gender'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Gender->del($id)) {
			$this->Session->setFlash(__('Gender deleted'));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>