<?php

class teste_RelatorioController extends Zend_Controller_Action {

    public function indexAction() {
         $pessoa = new Application_Model_DbTable_Sgrlpessoas();

        $this->_helper->layout->disableLayout();
        $sql = "SELECT
                    p.nome, 
                    p.cpf,
                    p.email,
                    p.telres,
                    p.telcom,
                    p.telcel,
                    p.logradouro,
                    p.numero,
                    p.bairro,
                    p.cep,
                    p.cidade,
                    p.codestadocivil,
                    p.complemento,
                    p.identidade,
                    p.gen01 as escola,
                    b.valorliqdo as boleto,
                    c.valorpago as cartao,
                    p.gen04 as pago

                    FROM grl_pessoas p
                    INNER JOIN evt_eventospessoas ep ON p.codgrlpessoa = ep.codgrlpessoa AND ep.codevteventoconfiguracao = 11
                    LEFT JOIN grl_boletos b ON b.moduloorigemidentificador = ep.codevteventopessoa AND b.situacao = 2 AND b.moduloorigem = 11
                    LEFT JOIN grl_cartoes c ON c.moduloorigemidentificador = ep.codevteventopessoa AND c.situacao = 2 AND c.moduloorigem = 11
                    ORDER BY p.nome ASC";

        $rpessoa = $pessoa->getAdapter()->query($sql)->fetchALL();

        $this->view->boleto = $rpessoa;
        
        /*$pessoa = new Application_Model_DbTable_Sgrlpessoas();

        $this->_helper->layout->disableLayout();
        $sql = "SELECT
                    p.nome,
                    p.email,
                    p.telres,
                    p.telcom,
                    p.telcel,
                    p.gen01 as escola,
                    b.valorliqdo as boleto,
                    c.valorpago as cartao,
                    p.gen04 as pago

                    FROM grl_pessoas p
                    INNER JOIN evt_eventospessoas ep ON p.codgrlpessoa = ep.codgrlpessoa AND ep.codevteventoconfiguracao = 11
                    LEFT JOIN grl_boletos b ON b.moduloorigemidentificador = ep.codevteventopessoa AND b.situacao = 2 AND b.moduloorigem = 11
                    LEFT JOIN grl_cartoes c ON c.moduloorigemidentificador = ep.codevteventopessoa AND c.situacao = 2 AND c.moduloorigem = 11
                    ORDER BY p.nome ASC";

        $rpessoa = $pessoa->getAdapter()->query($sql)->fetchALL();

        
        $this->view->boleto = $rpessoa;*/
    }
}