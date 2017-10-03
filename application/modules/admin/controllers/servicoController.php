<?php

class Admin_servicoController extends App_Controller_Action
{

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $atividades = new Application_Model_Atena_ServicoMdl();
        $this->view->atividades = $atividades->fetchAll(
            array(
                'ativo = ?' => 1)
        );

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();

            $destino =   getcwd()."/static/upload/servico/". $_FILES['arquivo']['name'];

            $arquivo_tmp = $_FILES['arquivo']['tmp_name'];

            move_uploaded_file( $arquivo_tmp, $destino  );

            // verifica se foi enviado um arquivo
            if ( isset( $_FILES[ 'arquivo' ][ 'name' ] ) && $_FILES[ 'arquivo' ][ 'error' ] == 0 ) {
                $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
                $nome = $_FILES['arquivo']['name'];

                // Pega a extensão
                $extensao = pathinfo($nome, PATHINFO_EXTENSION);

                // Converte a extensão para minúsculo
                $extensao = strtolower($extensao);

                // Somente imagens, .jpg;.jpeg;.gif;.png
                // Aqui eu enfileiro as extensões permitidas e separo por ';'
                // Isso serve apenas para eu poder pesquisar dentro desta String
                if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
                    // Cria um nome único para esta imagem
                    // Evita que duplique as imagens no servidor.
                    // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                    $novoNome = uniqid(time()) . $extensao;

                    // Concatena a pasta com o nome
                    $destino = 'imagens / ' . $novoNome;

                    // tenta mover o arquivo para o destino
                    if (@move_uploaded_file($arquivo_tmp, $destino)) {
                        echo 'Arquivo salvo com sucesso em : <strong>' . $destino . '</strong><br />';
                        echo ' < img src = "' . $destino . '" />';
                    }
                }
            }


            $atividade = new Application_Model_Atena_ServicoMdl();
            $dadosProcessados = array(
                "nome" =>  $data['nome'],
                "img" =>  $_FILES['arquivo']['name'] ,
                "descricao" => $data['descricao'],
                "ativo" => 1,
            );

            $atividade->_insert($dadosProcessados);
            $this->_redirect('/admin/servico');

        }


    }

    public function excluirAction()
    {
        //$id = $this->_request->getParam("id");

        $atividades = new Application_Model_Atena_ServicoMdl();
        $dadosProcessados = array(
            "idservico" => $this->_request->getParam("id"),
            "ativo" =>  0,
        );
        $atividades->_update($dadosProcessados);
        $this->_redirect('/admin/servico');
    }


}

