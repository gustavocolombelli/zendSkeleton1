<?php

class site_PetshopController extends Zend_Controller_Action
{

    public function init()
    {

    }
    

    public function indexAction()
    {
        $atividades = new Application_Model_Atena_PetshopMdl();
        $this->view->atividades = $atividades->fetchAll(
            array(
                'ativo = ?' => 1)
        );

    }


}


