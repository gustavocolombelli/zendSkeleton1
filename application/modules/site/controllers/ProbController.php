<?php

class site_ProbController extends Zend_Controller_Action
{

    public function init()
    {

    }
    

    public function indexAction()
    {
        $atividades = new Application_Model_Atena_CategoriaMdl();
        $this->view->atividades = $atividades->fetchAll(
            array(
                'ativo = ?' => 1)
        );

        $atividades1 = new Application_Model_Atena_TipoMdl();
        $this->view->atividades1 = $atividades1->fetchAll(
            array(
                'ativo = ?' => 1)
        );

    }

    public function internaAction()
    {

        $tipo = new Application_Model_Atena_TipoMdl();
        $this->view->tipo = $tipo->fetchAll(
            array('idtipo = ?' => $this->_request->getParam("id")));

        $atividades = new Application_Model_Atena_CategoriaMdl();
        $this->view->atividades = $atividades->fetchAll(
            array(
                'ativo = ?' => 1)
        );

        $atividades1 = new Application_Model_Atena_TipoMdl();
        $this->view->atividades1 = $atividades1->fetchAll(
            array(
                'ativo = ?' => 1)
        );
    }

}


