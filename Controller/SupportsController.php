<?php

class SupportsController extends AppController {

	var $name    = 'Supports';
	var $helpers = array('Html', 'Form');

	function beforeFilter()	{
		parent::beforeFilter();
		$this->Auth->allow('sendsupport');
	}
	
	function sendsupport()	{
		$this->set('isLoggedIn', $this->Auth->user());
		
		if ($this->request->is('post')) {
                        $this->Support->set($this->request->data);
			if ($this->Support->validates())
			{
				$Email = new CakeEmail();
				$Email->to($this->Config->get('email'));
				$Email->subject($this->request->data['Support']['subject']);
                            	if ($this->Auth->user())
                            	{
					$Email->from($this->Auth->user('username'));
                            	} else {
					$Email->from($this->request->data['Support']['email']);
        	                }
				
				$Email->emailFormat('text');
				$Email->template('sendsupport', 'default');
				$Email->send();

                            $this->set('message', $this->request->data['Support']['message']);
                            
                            echo "<script> alert('Sporočilo je bilo uspešno poslano!'); $('#supportdialog').dialog('close'); </script>";
			}
		}
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
		}
	}
}

?>
