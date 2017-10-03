<?php

class site_ServicosController extends Zend_Controller_Action
{

    public function init()
    {

    }
    

    public function indexAction()
    {
        $atividades = new Application_Model_Atena_ServicoMdl();
        $this->view->atividades = $atividades->fetchAll(
            array(
                'ativo = ?' => 1)
        );


    }


}


