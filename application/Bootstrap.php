<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initC() 
	{
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini",APPLICATION_ENV);
		Zend_Registry::set("config",$config);
	}
	
    public function _initRouter()
    {	
        $frontController = Zend_Controller_Front::getInstance();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/route.ini');
        $router = $frontController->getRouter();
        $router->addConfig($config,'routes');					
    }
	
	/**
	 * Inicializa o translate
	 *
	 * @return void
	 * @author Paulo Cesar Garcia
	 */
	public function _initTranslate()
	{
		$config = Zend_Registry::get('config');
		$translate = $config->resources->translate;
		$locale = $config->resources->locale;
		$zend_translate = new Zend_Translate($translate->adapter,
				$translate->data, $locale->default);
		Zend_Registry::set('Zend_Translate', $zend_translate);
	}	

	protected function _initDB()
	{
		$resource = $this->getPluginResource('multidb');
		$resource->init();
	
		Zend_Registry::set('site', $resource->getDb('site'));
	}

	public function _initHelpers(){
		Zend_Controller_Action_HelperBroker::addPath (APPLICATION_PATH . '/../library/App/Helpers', 'App_Helpers');
	}	
	
}

