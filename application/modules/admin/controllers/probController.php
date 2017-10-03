<?php

class Admin_probController extends App_Controller_Action
{

    public function init()
    {
    	parent::init();
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

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();

            if ($data['tipo'] == 1){
                $atividade = new Application_Model_Atena_CategoriaMdl();
                $dadosProcessados = array(
                    "nome" =>  $data['nome'],
                    "ativo" => 1,
                );
                $atividade->_insert($dadosProcessados);
                $this->_redirect('/admin/prob');
            }else{
                $atividade = new Application_Model_Atena_tipoMdl();
                $dadosProcessados = array(
                    "nome" =>  $data['nome'],
                    "descricao" => $data['descricao'],
                    "ativo" => 1,
                    "categoria_idcategoria" => $data['categoria']
                );
                $atividade->_insert($dadosProcessados);
                $this->_redirect('/admin/prob');
            }



        }


    }

    public function excluirAction()
    {
        //$id = $this->_request->getParam("id");
        $tipo = $this->_request->getParam("tipo");

        if($tipo == NULL){
            $atividades = new Application_Model_Atena_CategoriaMdl();
            $dadosProcessados = array(
                "idcategoria" => $this->_request->getParam("id"),
                "ativo" =>  0,
            );

            $atividades->_update($dadosProcessados);
            $this->_redirect('/admin/prob');
        }

        if($tipo == 2){
            $atividades = new Application_Model_Atena_TipoMdl();
            $dadosProcessados = array(
                "idtipo" => $this->_request->getParam("id"),
                "ativo" =>  0,
            );

            $atividades->_update($dadosProcessados);
            $this->_redirect('/admin/prob');

        }

    }


    public function editarAction()
    {

        $atividades1 = new Application_Model_Atena_TipoMdl();
        $this->view->atividades1 = $atividades1->fetchAll(
            array('idtipo = ?' => $this->_request->getParam("id")));

        $atividades = new Application_Model_Atena_CategoriaMdl();
        $this->view->atividades = $atividades->fetchAll(
            array(
                'ativo = ?' => 1)
        );


        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            $atividades = new Application_Model_Atena_TipoMdl();
            $dadosProcessados = array(
                "idtipo" => $this->_request->getParam("id"),
                "nome" =>  $data['nome'],
                "descricao" => $data['descricao'],
                "ativo" => 1,
                "categoria_idcategoria" => $data['categoria']
            );
            $atividades->_update($dadosProcessados);
            $this->_redirect('/admin/prob');

        }





    }

}

