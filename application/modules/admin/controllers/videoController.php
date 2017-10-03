<?php

class Admin_VideoController extends App_Controller_Action
{

    public function init()
    {
    	parent::init();
    }

    public function indexAction()
    {
        $atividades = new Application_Model_Atena_VideoMdl();
        $this->view->atividades = $atividades->fetchAll(
            array(
                'ativo = ?' => 1)
        );

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();

            $teste = explode('v=',$data['caminho'] );
            $data['caminho'] = $teste['1'];

            $atividade = new Application_Model_Atena_VideoMdl();
            $dadosProcessados = array(
                "nome" =>  $data['nome'],
                "caminho" => $data['caminho'] ,
                "ativo" => 1,
            );

            $atividade->_insert($dadosProcessados);
            $this->_redirect('/admin/video');

        }


    }

    public function excluirAction()
    {
        //$id = $this->_request->getParam("id");

           $atividades = new Application_Model_Atena_VideoMdl();
            $dadosProcessados = array(
                "idvideo" => $this->_request->getParam("id"),
                "ativo" =>  0,
            );
            $atividades->_update($dadosProcessados);
        $this->_redirect('/admin/video');
    }


}

