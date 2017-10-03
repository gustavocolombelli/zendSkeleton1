<?php

class Admin_authController extends App_Controller_Action
{

    public function indexAction()
    {
        $form = new Admin_Form_Login();
        $this->view->form = $form;

        if ($this->_request->isPost()) {
        	if ($form->isValid($this->data)) {
        		$authAdapter = $this->getAuthAdapter();
        		$authAdapter->setIdentity($this->data['login'])
        			->setCredential(md5($this->data['senha']));

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
    	$db = $resource->getDb('site');

    	$authAdapter = new Zend_Auth_Adapter_DbTable($db);
    	$authAdapter->setTableName('admin')
    		->setIdentityColumn('login')
    		->setCredentialColumn('senha');

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

