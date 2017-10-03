<?php

class Admin_AuthController extends App_Controller_Action
{

    public function indexAction()
    {
        $form = new Admin_Form_Login();
        $this->view->form = $form;

        if ($this->_request->isPost()) {
        	if ($form->isValid($this->data)) {
        		$authAdapter = $this->getAuthAdapter();
        		$authAdapter->setIdentity($this->data['login'])
        			->setCredential($this->data['senha']);

        		$result = $authAdapter->authenticate();

        		if ($result->isValid()) {
        			$auth = Zend_Auth::getInstance();
        			$auth->setStorage(new Zend_Auth_Storage_Session('admin'));
        			$dataAuth = $authAdapter->getResultRowObject(null, 'senha');
        			$dataAuth->role = 'intranet';
        			$auth->getStorage()
        				->write($dataAuth);
        			$this->_redirect("/admin");
        		} else {
        			$this->view->error = "Usuário ou senha inválidos";
        			$form->populate($this->data);
        		}
        	}
        }
    }

    private function getAuthAdapter()
    {
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$resource = $bootstrap->getPluginResource('multidb');
    	$db = $resource->getDb('uniamerica');

    	$authAdapter = new Zend_Auth_Adapter_DbTable($db);
    	$authAdapter->setTableName('vgrl_usuarios')
    		->setIdentityColumn('login')
    		->setCredentialColumn('senha')
    		->setCredentialTreatment('MD5(?) and statusreg=1 and ativo=1 and codusuario in(15856, 16695, 16779, 12881, 648, 14469, 14797, 16728, 16755, 14291, 505, 701, 15855, 595, 679, 10172, 426, 15325, 1127, 16444 , 16782, 17052, 16441)');

    	return $authAdapter;
    }

    public function logoutAction()
    {
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->layout->disableLayout();

    	$auth = Zend_Auth::getInstance();
    	$auth->setStorage(new Zend_Auth_Storage_Session('admin'));
    	$auth->clearIdentity();

    	$this->_redirect("/admin");
    }


}

