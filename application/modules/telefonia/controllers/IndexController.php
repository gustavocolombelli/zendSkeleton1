<?php

class Telefonia_IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$telefones = new Application_Model_Atena_TelefoniaDbt();
		$sql = "select * from telefonia where statusreg = 1 order by nome";
		$rs = $telefones->getAdapter()->query($sql)->fetchAll();

		$this->view->telefones = $rs;

 	}


	public function cadastroAction()
	{

		$telefones = new Application_Model_Atena_TelefoniaDbt();
		$sql = "select * from telefonia where statusreg = 1 order by nome";
		$rs = $telefones->getAdapter()->query($sql)->fetchAll();



		$this->view->telefones = $rs;


	}


	public function novoAction()
	{
		if ($this->_request->isPost()) {

			$data = $this->_request->getPost();
			$telefone = new Application_Model_Atena_TelefoniaMdl();
			$dadosProcessados = array(
				"nome" => $data["nome"],
				"ramal" => $data["ramal"],
				"departamento" => $data["departamento"],
				"statusreg" => 1
			);


			$telefone->_insert($dadosProcessados);
			$this->_redirect('/telefonia/index/cadastro');

		}

	}


	public function excluirAction()
	{

		$atividadesprecos = new Application_Model_Atena_TelefoniaDbt();
		$sql ="UPDATE telefonia SET statusreg = 0 WHERE codtelefonia =".$this->_request->getParam("id_pessoa");
		$atividadesprecos->getAdapter()->query($sql);

		$this->_redirect('/telefonia/index/cadastro');


	}



}