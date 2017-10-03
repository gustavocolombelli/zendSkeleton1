<?php

class Contatos_IndexController extends Zend_Controller_Action
{
 
    public function indexAction()
    {
        $ocorrencias = new Application_Model_Atena_OcorrenciasDbt();
        $sql = "select * from ocorrencia order by tipo_problema";
        $rs = $ocorrencias->getAdapter()->query($sql)->fetchAll();
        $this->view->ocorrencias = $rs;
    }

    public function cadastroocorrenciaAction(){
        
       if ($this->_request->isPost()) {

            $data = $this->_request->getPost();
    
            $ocorrencia = new Application_Model_Atena_OcorrenciasMdl();
            $dadosProcessados = array(
                "nome_solicitante" => $data["nomeSolicitante"],
                "nome_atendente" => $data["nomeAtendente"],
                "tipo_problema" => $data["tipoProblema"],
                "detalhamento_solicitacao" => $data["detalhamentoSolicitacao"],
                "detalhamento_atendimento" => $data["detalhamentoAtendimento"]

            );
         
            $ocorrencia->_insert($dadosProcessados);
            $this->_redirect('/index');

        }

       
    }

    public function pesquisarcontatoAction(){
    	if ($this->_request->isPost()) {

            $data = $this->_request->getPost();

             $contatos = new Application_Model_Atena_ContatosDbt();

             $sql = "select * from pessoa where (statusreg =1 AND (nome LIKE '%".$data['search']."%'
                                                    OR cargo LIKE '%".$data['search']."%'
                                                    OR funcao LIKE '%".$data['search']."%'
                                                    OR uf LIKE '%".$data['search']."%'
                                                    OR nomeinstituicao LIKE '%".$data['search']."%'
                                                    OR nomemantenedora LIKE '%".$data['search']."%')) order by nome";

             $rs = $contatos->getAdapter()->query($sql)->fetchAll();             

             $this->view->contatos = $rs;
      
        }
    }

    public function mensagensAction(){

        
    }
    
    public function pesquisarinstituicaoAction(){
    	echo "pesquisarinstituicaoAction";
    }

    public function pesquisarmantenedoraAction(){
    	echo "pesquisarmantenedoraAction";
    }
    public function principaiscontatosAction(){
    	$contatos = new Application_Model_Atena_ContatosDbt();
        $sql = "select * from pessoa where statusreg = 1 AND prioridade = 1 order by nome";
        $rs = $contatos->getAdapter()->query($sql)->fetchAll();
        $this->view->contatos = $rs;
    }

    public function excluircontatoAction(){          

            $contato = new Application_Model_Atena_ContatosMdl();

            $dadosProcessados = array(
                "cod_pessoa" => $this->_request->getParam("id"),
                "statusreg" =>  0,
            );
   
            $contato->_update($dadosProcessados);

        $this->_redirect('/index/pesquisarcontato');
    }

    public function expandirAction(){

        $contato = new Application_Model_Atena_ContatosDbt();

        $contatoEspecifico= $this->_request->getParam("id");

        $sql = "select * from pessoa where cod_pessoa = ". $contatoEspecifico. "";
        $contatoEspecifico = $contato->getAdapter()->query($sql)->fetchAll();

        $this->view->contato = $contatoEspecifico;

         if ($this->_request->isPost()) {

            $data = $this->_request->getPost();
      
            $contato = new Application_Model_Atena_ContatosMdl();
            $dadosProcessados = array(
                "cod_pessoa" => $this->_request->getParam("id"),
                "nome" => $data["nome"],
                "email1" => $data["email1"],
                "email2" => $data["email2"],
                "email3" => $data["email3"],
                "nomeinstituicao" => $data["nomeinstituicao"],
                "nomemantenedora" => $data["nomemantenedora"],
                "telefone1" => $data["telefone1"],
                "telefone2" => $data["telefone2"],
                "cidade" => $data["cidade"],
                "uf" => $data["uf"],
                "numero" => $data["numero"],
                "origemdados" => $data["origemdados"],
                "logradouro" => $data["logradouro"],
                "observacao" => $data["observacao"],
                "bairro" => $data["bairro"],
                "complemento" => $data["complemento"],
                "publicaparticular" => $data["publicaparticular"],
                "site" => $data["site"],
                "atividades" => $data["atividades"],
                "cargo" => $data["cargo"],
                "funcao" => $data["funcao"],
                "cep" => $data["cep"]

            );
            
            $contato->_update($dadosProcessados);
            $this->_redirect('/index/mensagens');
        }
    }

    public function favoritarAction(){
        $contato = new Application_Model_Atena_ContatosMdl();

            $dadosProcessados = array(
                "cod_pessoa" => $this->_request->getParam("id"),
                "prioridade" =>  1,
            );
        $contato->_update($dadosProcessados);
        $this->_redirect('/index');

    }
}


