<?php

class teste_EmailsController extends Zend_Controller_Action {

    public function init() {

    }





    public function testeAction() {
        die('teste');
    }

    public function enviaEmail($dadosProcessados){



    }

    public function bolsistaacAction(){

        $lCandidatos = new Application_Model_Prscandidatos();
        $candidatos = $lCandidatos->fetchAll(array(
                'statusreg = ?' => 1,
                'codprsprocessoseletivo = ? ' => 38,
                'treineiro = ? ' => 0,
                'selecionadobolsa = ? ' => 1));

        foreach ($candidatos as $key => $value){

            $myView = new Zend_View();
            $myView->addScriptPath(APPLICATION_PATH . '/modules/teste/views/scripts/emails/');

            $html_body = $myView->render('BolsistaAprovadoClassificado.phtml');
//            $html_body = $myView->render('BolsistaAprovadoNaoClassificado.phtml');
//            $html_body = $myView->render('VestibulandoAprovado.phtml');

            $html_body = preg_replace('@\{(\w+)\}@e', '@$value["$1"]', $html_body);

            $email = 'flaviofagundes@uniamerica.br';
            $name = 'Paulo Cesar';
            $pass = (md5('uniamerica'));
            $token = (md5($email.$name.$pass));

            $dadosProcessados = array(
                "toemail" =>  $email,
                "toname" =>  $name,
                "subject" => "Processo Seletivo Uniamérica",
                "msg" =>  $html_body,
                "html" =>  "1",
                "replyname" =>  "Vestibular",
                "replyemail" =>  "vestibular@uniamerica.br",
                "fromemail" =>  "vestibular@uniamerica.br",
                "fromname" =>  "",
                "datacriacao" => date("Ymd"),
                "dataentrega" => date("Ymd"),
                "situacao" =>  "0",
                "token" =>  $token,
            );

            $body = json_encode($dadosProcessados);
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "http://uniamerica.br/api/emails/put");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: OAuth 2.0 token here"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $result = curl_exec($ch);

            echo '<pre>';
            var_dump($dadosProcessados);
            die();

        }

    die();

    }

    public function bolsistaanAction(){

        $lCandidatos = new Application_Model_Prscandidatos();
        $data = array(1, 2);
        $candidatos = $lCandidatos->fetchAll(array(
            'statusreg = ?' => 1,
            'codprsprocessoseletivo = ? ' => 38,
            'treineiro = ? ' => 0,
            'bolsista IN ? ' => $data,
            'selecionadobolsa = ? ' => 0));

        echo '<pre>';
        var_dump($candidatos);
        die();


        foreach ($candidatos as $key => $value){

            $myView = new Zend_View();
            $myView->addScriptPath(APPLICATION_PATH . '/modules/teste/views/scripts/emails/');

            $html_body = $myView->render('BolsistaAprovadoClassificado.phtml');
//            $html_body = $myView->render('BolsistaAprovadoNaoClassificado.phtml');
//            $html_body = $myView->render('VestibulandoAprovado.phtml');

            $html_body = preg_replace('@\{(\w+)\}@e', '@$value["$1"]', $html_body);

            $email = 'flaviofagundes@uniamerica.br';
            $name = 'Paulo Cesar';
            $pass = (md5('uniamerica'));
            $token = (md5($email.$name.$pass));

            $dadosProcessados = array(
                "toemail" =>  $email,
                "toname" =>  $name,
                "subject" => "Processo Seletivo Uniamérica",
                "msg" =>  $html_body,
                "html" =>  "1",
                "replyname" =>  "Vestibular",
                "replyemail" =>  "vestibular@uniamerica.br",
                "fromemail" =>  "vestibular@uniamerica.br",
                "fromname" =>  "",
                "datacriacao" => date("Ymd"),
                "dataentrega" => date("Ymd"),
                "situacao" =>  "0",
                "token" =>  $token,
            );

            $body = json_encode($dadosProcessados);
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "http://uniamerica.br/api/emails/put");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: OAuth 2.0 token here"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $result = curl_exec($ch);

            echo '<pre>';
            var_dump($dadosProcessados);
            die();

        }

        die();

    }

    public function bolsistarAction(){

        $lCandidatos = new Application_Model_Prscandidatos();
        $candidatos = $lCandidatos->fetchAll(array(
            'statusreg = ?' => 1,
            'codprsprocessoseletivo = ? ' => 38,
            'treineiro = ? ' => 0,
            'selecionadobolsa = ? ' => 1));

        foreach ($candidatos as $key => $value){

            $myView = new Zend_View();
            $myView->addScriptPath(APPLICATION_PATH . '/modules/teste/views/scripts/emails/');

            $html_body = $myView->render('BolsistaAprovadoClassificado.phtml');
//            $html_body = $myView->render('BolsistaAprovadoNaoClassificado.phtml');
//            $html_body = $myView->render('VestibulandoAprovado.phtml');

            $html_body = preg_replace('@\{(\w+)\}@e', '@$value["$1"]', $html_body);

            $email = 'flaviofagundes@uniamerica.br';
            $name = 'Paulo Cesar';
            $pass = (md5('uniamerica'));
            $token = (md5($email.$name.$pass));

            $dadosProcessados = array(
                "toemail" =>  $email,
                "toname" =>  $name,
                "subject" => "Processo Seletivo Uniamérica",
                "msg" =>  $html_body,
                "html" =>  "1",
                "replyname" =>  "Vestibular",
                "replyemail" =>  "vestibular@uniamerica.br",
                "fromemail" =>  "vestibular@uniamerica.br",
                "fromname" =>  "",
                "datacriacao" => date("Ymd"),
                "dataentrega" => date("Ymd"),
                "situacao" =>  "0",
                "token" =>  $token,
            );

            $body = json_encode($dadosProcessados);
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "http://uniamerica.br/api/emails/put");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: OAuth 2.0 token here"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $result = curl_exec($ch);

            echo '<pre>';
            var_dump($dadosProcessados);
            die();

        }

        die();

    }

    public function vestibulandoaAction(){

        $lCandidatos = new Application_Model_Prscandidatos();
        $candidatos = $lCandidatos->fetchAll(array(
            'statusreg = ?' => 1,
            'codprsprocessoseletivo = ? ' => 38,
            'treineiro = ? ' => 0,
            'selecionadobolsa = ? ' => 1));

        foreach ($candidatos as $key => $value){

            $myView = new Zend_View();
            $myView->addScriptPath(APPLICATION_PATH . '/modules/teste/views/scripts/emails/');

//            $html_body = $myView->render('BolsistaAprovadoClassificado.phtml');
//            $html_body = $myView->render('BolsistaAprovadoNaoClassificado.phtml');
            $html_body = $myView->render('VestibulandoAprovado.phtml');

            $html_body = preg_replace('@\{(\w+)\}@e', '@$value["$1"]', $html_body);

            $email = 'flaviofagundes@uniamerica.br';
            $name = 'Paulo Cesar';
            $pass = (md5('uniamerica'));
            $token = (md5($email.$name.$pass));

            $dadosProcessados = array(
                "toemail" =>  $email,
                "toname" =>  $name,
                "subject" => "Processo Seletivo Uniamérica",
                "msg" =>  $html_body,
                "html" =>  "1",
                "replyname" =>  "Vestibular",
                "replyemail" =>  "vestibular@uniamerica.br",
                "fromemail" =>  "vestibular@uniamerica.br",
                "fromname" =>  "",
                "datacriacao" => date("Ymd"),
                "dataentrega" => date("Ymd"),
                "situacao" =>  "0",
                "token" =>  $token,
            );

            $body = json_encode($dadosProcessados);
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "http://uniamerica.br/api/emails/put");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: OAuth 2.0 token here"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $result = curl_exec($ch);

            echo '<pre>';
            var_dump($dadosProcessados);
            die();

        }

        die();

    }

    public function vestibulandonAction(){


        $lCandidatos = new Application_Model_Prscandidatos();
        $candidatos = $lCandidatos->fetchAll(array(
            'statusreg = ?' => 1,
            'codprsprocessoseletivo = ? ' => 38,
            'treineiro = ? ' => 0,
            'selecionadobolsa = ? ' => 1));

        foreach ($candidatos as $key => $value){

            $myView = new Zend_View();
            $myView->addScriptPath(APPLICATION_PATH . '/modules/teste/views/scripts/emails/');

            $html_body = $myView->render('BolsistaAprovadoClassificado.phtml');
//            $html_body = $myView->render('BolsistaAprovadoNaoClassificado.phtml');
//            $html_body = $myView->render('VestibulandoAprovado.phtml');

            $html_body = preg_replace('@\{(\w+)\}@e', '@$value["$1"]', $html_body);

            $email = 'flaviofagundes@uniamerica.br';
            $name = 'Paulo Cesar';
            $pass = (md5('uniamerica'));
            $token = (md5($email.$name.$pass));

            $dadosProcessados = array(
                "toemail" =>  $email,
                "toname" =>  $name,
                "subject" => "Processo Seletivo Uniamérica",
                "msg" =>  $html_body,
                "html" =>  "1",
                "replyname" =>  "Vestibular",
                "replyemail" =>  "vestibular@uniamerica.br",
                "fromemail" =>  "vestibular@uniamerica.br",
                "fromname" =>  "",
                "datacriacao" => date("Ymd"),
                "dataentrega" => date("Ymd"),
                "situacao" =>  "0",
                "token" =>  $token,
            );

            $body = json_encode($dadosProcessados);
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "http://uniamerica.br/api/emails/put");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: OAuth 2.0 token here"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $result = curl_exec($ch);

            echo '<pre>';
            var_dump($dadosProcessados);
            die();

        }

        die();

    }

    public function vestibulandotaAction(){

        $lCandidatos = new Application_Model_Prscandidatos();
        $candidatos = $lCandidatos->fetchAll(array(
            'statusreg = ?' => 1,
            'codprsprocessoseletivo = ? ' => 38,
            'treineiro = ? ' => 0,
            'selecionadobolsa = ? ' => 1));

        foreach ($candidatos as $key => $value){

            $myView = new Zend_View();
            $myView->addScriptPath(APPLICATION_PATH . '/modules/teste/views/scripts/emails/');

            $html_body = $myView->render('BolsistaAprovadoClassificado.phtml');
//            $html_body = $myView->render('BolsistaAprovadoNaoClassificado.phtml');
//            $html_body = $myView->render('VestibulandoAprovado.phtml');

            $html_body = preg_replace('@\{(\w+)\}@e', '@$value["$1"]', $html_body);

            $email = 'flaviofagundes@uniamerica.br';
            $name = 'Paulo Cesar';
            $pass = (md5('uniamerica'));
            $token = (md5($email.$name.$pass));

            $dadosProcessados = array(
                "toemail" =>  $email,
                "toname" =>  $name,
                "subject" => "Processo Seletivo Uniamérica",
                "msg" =>  $html_body,
                "html" =>  "1",
                "replyname" =>  "Vestibular",
                "replyemail" =>  "vestibular@uniamerica.br",
                "fromemail" =>  "vestibular@uniamerica.br",
                "fromname" =>  "",
                "datacriacao" => date("Ymd"),
                "dataentrega" => date("Ymd"),
                "situacao" =>  "0",
                "token" =>  $token,
            );

            $body = json_encode($dadosProcessados);
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "http://uniamerica.br/api/emails/put");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: OAuth 2.0 token here"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $result = curl_exec($ch);

            echo '<pre>';
            var_dump($dadosProcessados);
            die();

        }

        die();

    }


    public function vestibulandotrAction(){

        $lCandidatos = new Application_Model_Prscandidatos();
        $candidatos = $lCandidatos->fetchAll(array(
            'statusreg = ?' => 1,
            'codprsprocessoseletivo = ? ' => 38,
            'treineiro = ? ' => 0,
            'selecionadobolsa = ? ' => 1));

        foreach ($candidatos as $key => $value){

            $myView = new Zend_View();
            $myView->addScriptPath(APPLICATION_PATH . '/modules/teste/views/scripts/emails/');

            $html_body = $myView->render('BolsistaAprovadoClassificado.phtml');
//            $html_body = $myView->render('BolsistaAprovadoNaoClassificado.phtml');
//            $html_body = $myView->render('VestibulandoAprovado.phtml');

            $html_body = preg_replace('@\{(\w+)\}@e', '@$value["$1"]', $html_body);

            $email = 'flaviofagundes@uniamerica.br';
            $name = 'Paulo Cesar';
            $pass = (md5('uniamerica'));
            $token = (md5($email.$name.$pass));

            $dadosProcessados = array(
                "toemail" =>  $email,
                "toname" =>  $name,
                "subject" => "Processo Seletivo Uniamérica",
                "msg" =>  $html_body,
                "html" =>  "1",
                "replyname" =>  "Vestibular",
                "replyemail" =>  "vestibular@uniamerica.br",
                "fromemail" =>  "vestibular@uniamerica.br",
                "fromname" =>  "",
                "datacriacao" => date("Ymd"),
                "dataentrega" => date("Ymd"),
                "situacao" =>  "0",
                "token" =>  $token,
            );

            $body = json_encode($dadosProcessados);
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "http://uniamerica.br/api/emails/put");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: OAuth 2.0 token here"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $result = curl_exec($ch);

            echo '<pre>';
            var_dump($dadosProcessados);
            die();

        }

        die();

    }
}