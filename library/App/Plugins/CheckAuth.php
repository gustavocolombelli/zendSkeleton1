<?php

class App_Plugins_CheckAuth extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $module = $request->getModuleName();
        $resource = $request->getControllerName();
        $action = $request->getActionName();

       $listaPermitidos = array('admin');

        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session($module));

        if (!$auth->hasIdentity() and in_array($module, $listaPermitidos)) {

            $request->setModuleName($module)
                        ->setControllerName('auth')
                        ->setActionName('index');
        }
    }
}