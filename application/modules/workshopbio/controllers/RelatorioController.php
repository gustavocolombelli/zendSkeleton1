<?php

class Workshopbio_RelatorioController extends Zend_Controller_Action {

    public function indexAction() {
        $pessoa = new Application_Model_DbTable_Sgrlpessoas();

        $this->_helper->layout->disableLayout();
        $sql = "SELECT
                    p.nome, 
                    p.email,
                    p.telres,
                    p.telcom,
                    p.telcel,
                    p.datacadastro,
                    b.valorliqdo as boleto,
                    c.valorpago as cartao

                    FROM grl_pessoas p
                    INNER JOIN evt_eventospessoas ep ON p.codgrlpessoa = ep.codgrlpessoa AND ep.codevteventoconfiguracao = 10
                    LEFT JOIN grl_boletos b ON b.moduloorigemidentificador = ep.codevteventopessoa AND b.situacao = 2 AND b.moduloorigem = 10
                    LEFT JOIN grl_cartoes c ON c.moduloorigemidentificador = ep.codevteventopessoa AND c.situacao = 2 AND c.moduloorigem = 10
                    ORDER BY p.nome ASC";

        $rpessoa = $pessoa->getAdapter()->query($sql)->fetchALL();

        /*
         */



        $this->view->boleto = $rpessoa;
    }

}