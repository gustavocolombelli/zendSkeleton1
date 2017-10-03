<?php

abstract class Sit_Controller_Action extends Zend_Controller_Action {

    public function init() 
    {
    	$configuracoes = new Application_Model_Pagconfiguracoes();
    	$res = $configuracoes->find(1);
    	if(is_array($res)) {
    		foreach($res as $key => $value) {
    			$key = strtoupper($key);
    			if(!defined($key)) {
    				define($key, $value);
    			}
    		}
    	}
    	
    	$lBanners = new Application_Model_Pagpublicidades();
    	$this->view->vPublicidades = $lBanners->_publicidades();
    	
    	
    	
    	
    	
        

    	
    	
    	
    		
        
    }
}