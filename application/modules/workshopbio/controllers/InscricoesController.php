<?php

class Workshopbio_InscricoesController extends Zend_Controller_Action {

    public function init()
    {
        $this->_helper->FlashMessenger()
                ->setNamespace('success')
                ->addMessage('Inscrições Encerradas.');

        $this->_redirect("/workshopbio/");
    }
    public function indexAction() {

        $request = $this->getRequest();
        $cadastro = new Workshopbio_Form_Inscricao();
        $this->view->cadastro = $cadastro;


        if ($this->getRequest()->isPost()){

            if ($cadastro->isValid($request->getPost())){
                    $pessoa = new Application_Model_Sgrlpessoas();
                    $contador = new Application_Model_Sgrlcontadores();
                    $eventopessoa = new Application_Model_Evteventospessoas();

                    $dados = $this->_request->getPost();

                    $codgrlpessoa = $contador->FncChavePrimaria("codgrlpessoa", "grl_pessoas");
                    $codevteventopessoa = $contador->FncChavePrimaria("codevteventopessoa", "evt_eventospessoas");

                    $dadosPessoa = array(
                        'codgrlpessoa' => $codgrlpessoa,
                        'codcliente' => 0,
                        'nome' => $dados['nome'],
                        'nascimentodata' => vsprintf("%s%s%s", array_reverse(explode("/", $dados["nascimentodata"]))),
                        'nomepai' => '',
                        'nomemae' => '',
                        'sexo' => $dados['sexo'],
                        'codestadocivil' => $dados['codestadocivil'],
                        'logradouro' => $dados['logradouro'],
                        'numero' => $dados['numero'],
                        'complemento' => $dados['complemento'],
                        'bairro' => $dados['bairro'],
                        'cidade' => $dados['cidade'],
                        'uf' => $dados['uf'],
                        'pais' => $dados['pais'],
                        'cep' => $dados['cep'],
                        'identidade' => $dados['identidade'],
                        'cpf' => $dados['cpf'],
                        'telres' => $dados['telres'],
                        'telcom' => $dados['telcom'],
                        'telcel' => $dados['telcel'],
                        'email' => $dados['email'],
                        'datacadastro' => date("Ymd"),
                        'statusreg' => 1,
                        'gen01' =>  $dados['tipo'],
                        'gen02' =>  $dados['ra'],
                        'gen03' =>  319,
                        'senha' => substr(md5($codgrlpessoa), 8),
                        'hash' => md5($codgrlpessoa));

                    $dbTable = new Application_Model_DbTable_Sgrlpessoas();
                    $db = $dbTable->getAdapter()->beginTransaction();

                    try {

                        $pessoa->_insert($dadosPessoa);
                        $db->commit();

                        $this->Email($dados['email'], $dados['nome'], md5($codgrlpessoa));

                        $this->_redirect('/workshopbio/inscricoes/confirmacao/chave/' . md5($codgrlpessoa));

                    } catch (Exception $e) {
                        $db->rollBack();
                        throw $e;
                    }
                }

        }
    }

    public function Email($email, $nome, $hash) {

        $compilada = array(
            'email_de' => $email,
            'nome_de' => $nome,
            'hash' => $hash,
        );

        //enviando mensagem de confirmação para o e-mail do usuario
        $myView = new Zend_View();
        $myView->addScriptPath(APPLICATION_PATH . '/modules/workshopbio/views/scripts/inscricoes/');

        $html_body = $myView->render('email.phtml');
        $html_body = preg_replace('@\{(\w+)\}@e', '@$compilada["$1"]', $html_body);

        $email = new App_SendMail();
        $email->send($compilada['email_de'], 'Uniamérica', 'Inscrição - Workshop de Biomedicina ' . date("Ymd-His"), $html_body, $compilada['email_de'], $compilada['email_de'], $compilada['nome_de']);

    }

    public function msgAction() {

    }

    public function validarAction() {
        $data = $this->_request->getPost();

        $data['nascimentodata'] = vsprintf("%s%s%s", array_reverse(explode("/", $data["nascimentodata"])));

        $pessoa = new Application_Model_DbTable_Sgrlpessoas();

        $sql = "SELECT
        p.codgrlpessoa
        FROM grl_pessoas p
        INNER JOIN evt_eventospessoas ep ON p.codgrlpessoa = ep.codgrlpessoa AND ep.codevteventoconfiguracao = 10
        WHERE p.statusreg = 1
        AND (
                (p.email = '%s') OR
                (p.nome = '%s' AND p.nascimentodata = %d) OR
                (p.nome = '%s' AND p.identidade = '%s')
            )";

        $sql = sprintf($sql, $data['email'], $data['nome'], $data['nascimentodata'], $data['nome'], $data['identidade']);

        if (is_array($pessoa->getAdapter()->query($sql)->fetch())) {
            echo 'nao';
            exit;
        } else {
            echo 'sim';
            exit;
        }
        exit;
    }

    public function confirmacaoAction() {

        $pessoa = new Application_Model_Sgrlpessoas();
        $rpessoa = $pessoa->findBy(array('hash = ?' => $this->_request->getParam("chave")));

        $congresso = new Application_Model_Evteventospessoas();
        $rcongresso = $congresso->findBy(array('codgrlpessoa = ?' => $rpessoa['codgrlpessoa']));

        $this->view->congresso = $rcongresso;
        $this->view->chave = $this->_request->getParam("chave");
    }

    public function reimprimirAction() {

        if ($this->_request->isPost())
        {

            //cruzar dados tabela grl_pessoa e evt_eventospessoas
            $pessoa = new Application_Model_DbTable_Sgrlpessoas();
            $sql = "SELECT
                    p.hash
                    FROM grl_pessoas p
                    WHERE p.gen03 = 319 AND p.nascimentodata = '%s' AND p.email = '%s'";
            $sql = sprintf($sql, vsprintf("%s%s%s", array_reverse(explode("/", $this->_request->getParam("nascimentodata")))), $this->_request->getParam("email"));


            $rpessoa = $pessoa->getAdapter()->query($sql)->fetch();

            if (is_array($rpessoa)) {

                $this->_redirect('/workshopbio/inscricoes/pagamento/chave/' . ($rpessoa["hash"]));
            } else {
                $this->view->erro = 1;
            }
        }
    }

    public function pagamentoAction() {


        error_reporting(1);



        $dias_de_prazo_para_pagamento = 1;

        $id = $this->_request->getParam("chave");

        //----------------------------------------------------------------------------
        //  Verifica se existe a inscricao
        //----------------------------------------------------------------------------
        $pessoa = new Application_Model_Sgrlpessoas();
        $lPessoa = $pessoa->findBy(array("hash = ?" => $id));

        if (empty($lPessoa['codgrlpessoa'])) {

            $this->_helper->FlashMessenger()
                    ->setNamespace('error')
                    ->addMessage('Sua inscrição não foi encontrada em nossos registros.');

            $this->redirect("/workshopbio/inscricoes/msg");
        }


        //----------------------------------------------------------------------------
        //  Verifica se está inscrito no evento
        //----------------------------------------------------------------------------
 //       $evento = new Application_Model_Evteventospessoas();
 //       $levento = $evento->findBy(array('codgrlpessoa = ?' => $lPessoa["codgrlpessoa"]));


        // TODO validar se acabou o prazo
        //----------------------------------------------------------------------------
        //  Pega o valor do boleto
        //----------------------------------------------------------------------------
       $tabelasprecosatividades = new Application_Model_Sfinevttabelasprecosatividades();
        $ltabelasprecosatividades = $tabelasprecosatividades->find($lPessoa["gen01"]);


        //----------------------------------------------------------------------------
        //  Verifica se o boleto não está pago
        //----------------------------------------------------------------------------
        $boletos = new Application_Model_Sgrlboletos();
        $lboleto = $boletos->findBy(array(
            'moduloorigem = ?' => 10,
            'moduloorigemidentificador = ?' => $lPessoa["codgrlpessoa"],
            'situacao = ?' => 2,
            'statusreg = ?' => 1));

        if (is_array($lboleto)) {
            $this->_helper->FlashMessenger()
                    ->setNamespace('success')
                    ->addMessage('Sua inscrição já foi paga.');

            $this->redirect("/workshopbio/inscricoes/msg");
        }

        //----------------------------------------------------------------------------
        //  Verifica se ja existe boleto para esta inscricao
        //----------------------------------------------------------------------------
        $boletos = new Application_Model_Sgrlboletos();

        $lboleto = $boletos->findBy(array(
            'statusreg = ?' => 1,
            'moduloorigem = ?' => 10,
 //'moduloorigemidentificador = ?' => $this->_candidato["codprscandidato"]
                'codgrlpessoa = ?' => $lPessoa["codgrlpessoa"]));

        if (is_array($lboleto)) {

            //----------------------------------------------------------------------------
            //  Altera a data de vencimento, se estiver vencido
            //----------------------------------------------------------------------------
            if ($lboleto["vencimento"] < date("Ymd")) {
                $boletos->_update(array(
                    "codgrlboleto" => $lboleto["codgrlboleto"],
                    "vencimento" => date("Ymd", time() + ($dias_de_prazo_para_pagamento * 86400))));
                $lboleto = $boletos->find($lboleto["codgrlboleto"]);
            }
        } else {


            //----------------------------------------------------------------------------
            //  Cadastrar o boleto
            //----------------------------------------------------------------------------
            $contador = new Application_Model_Sgrlcontadores();
            $lNossonumero = $contador->FncChavePrimaria('nossonumeroavulso', 'grl_nossonumero');

            if (empty($lNossonumero)) {
                $this->_helper->FlashMessenger()
                        ->setNamespace('error')
                        ->addMessage('Não foi possivel gerar o número de indenticação do boleto, tente novamente.');

                $this->redirect("/workshopbio/inscricoes/msg");
            }

            $data = array(
                "codgrlboleto" => $contador->FncChavePrimaria('codgrlboleto', 'grl_boletos'),
                "codcliente" => 0,
                "codgrlpessoa" => $lPessoa["codgrlpessoa"],
                "datacadastro" => date("Ymd"),
                "valor" => $ltabelasprecosatividades["valor"],
                "vencimento" => date("Ymd", time() + ($dias_de_prazo_para_pagamento * 86400)),
                "nossonumero" => $lNossonumero,
                "situacao" => 1,
                "datapagamento" => -1,
                "statusreg" => 1,
                "horacadastro" => date("His"),
                "datamodificacao" => -1,
                "horamodificacao" => -1,
                "dataprocessamento" => -1,
                "valordesconto" => 0,
                "valorliqdo" => -1,
                "moduloorigem" => 10,
                "moduloorigemidentificador" => $levento["codevteventopessoa"],
                "localregpgto" => 3,
                "localregpgtoidentificador" => -1,
                "hash" => md5($lPessoa["codgrlpessoa"] . date("Ymd")));

            $lboleto = $boletos->find($boletos->_insert($data));
        }



        $taxa_boleto = 0;
        $data_venc = sprintf("%s/%s/%s", substr($lboleto["vencimento"], -2), substr($lboleto["vencimento"], -4, 2), substr($lboleto["vencimento"], -8, 4));
        $valor_cobrado = number_format(($lboleto["valor"] / 100), 2, ',', '');
        $valor_cobrado = str_replace(",", ".", $valor_cobrado);
        $valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

        $dadosboleto["nosso_numero"] = $lboleto["nossonumero"];
        $dadosboleto["numero_documento"] = $lboleto["nossonumero"];   // Num do pedido ou do documento
        $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        $dadosboleto["data_documento"] = sprintf("%s/%s/%s", substr($lboleto["datacadastro"], -2), substr($lboleto["datacadastro"], -4, 2), substr($lboleto["datacadastro"], -8, 4)); // Data de emissão do Boleto
        $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
        $dadosboleto["valor_boleto"] = $valor_boleto;   // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

        // DADOS DO SEU CLIENTE
        $dadosboleto["sacado"] = $lPessoa["nome"];
        $dadosboleto["endereco1"] = sprintf("%s %s", $lPessoa["logradouro"], $lPessoa["numero"]);
        $dadosboleto["endereco2"] = sprintf("%s - %s CEP: %s", $lPessoa["cidade"], $lPessoa["uf"], $lPessoa["cep"]);


        // INFORMACOES PARA O CLIENTE
        $dadosboleto["demonstrativo1"] = "Faculdade União das Américas";
        $dadosboleto["demonstrativo2"] = 'Congresso Internacional de Educação';
        $dadosboleto["demonstrativo3"] = "";

        // INSTRUÇÕES PARA O CAIXA
        $dadosboleto["instrucoes1"] = "";
        $dadosboleto["instrucoes2"] = "- Não receber após o vencimento";
        $dadosboleto["instrucoes3"] = "";
        $dadosboleto["instrucoes4"] = "";

        // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        $dadosboleto["quantidade"] = "";
        $dadosboleto["valor_unitario"] = "";
        $dadosboleto["aceite"] = "N";
        $dadosboleto["especie"] = "R$";
        $dadosboleto["especie_doc"] = "DS";


        // DADOS DA SUA CONTA - BANCO DO BRASIL
        $dadosboleto["agencia"] = "0140"; // Num da agencia, sem digito
        $dadosboleto["conta"] = "11";   // Num da conta, sem digito

        // DADOS PERSONALIZADOS - BANCO DO BRASIL
        $dadosboleto["convenio"] = "2571023";  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
        $dadosboleto["contrato"] = "19080628"; // Num do seu contrato
        $dadosboleto["carteira"] = "18";
        $dadosboleto["variacao_carteira"] = "-027";  // Variação da Carteira, com traço (opcional)

        // TIPO DO BOLETO
        $dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
        $dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos

        // SEUS DADOS
        $dadosboleto["identificacao"] = "Faculdade União das Américas";
        $dadosboleto["cpf_cnpj"] = "18.715.633/0001-41";
        $dadosboleto["endereco"] = "Av. Tarquínio Joslin dos Santos, 1000";
        $dadosboleto["cidade_uf"] = "Foz do Iguaçu / Paraná";
        $dadosboleto["cedente"] = "Associação Internacional União das Américas";


        // NÃO ALTERAR!
        require_once "boletophp-bb/include/funcoes_bb.php";
        require_once "boletophp-bb/include/layout_bb.php";


        die;
    }

}

