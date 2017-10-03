<?php

class Workshopbio_ContatoController extends Zend_Controller_Action
{


      public function indexAction()
    {
        // action body
        if ($this->_request->isPost()) {
                $data = $this->_request->getPost();

                //criando arquivo de confirmação
                $this->EmailConfirmacao($data['email'], $data['nome'], $data['telefone'], $data['assunto'], $data['mensagem']);

                $this->_redirect('/congresso/contato/enviado');

                //finalizar
            }
    }

    public function enviadoAction()
    {

    }

    public function confirmaenvioAction()
    {

    }

    public function confirmarAction()
    {

            //if(isset($this->_request->getParam('chave')) && $this->_request->getParam('chave') != '')
            if($this->_request->getParam('chave') != '' )
            {
                $file = APPLICATION_PATH . '/modules/congresso/views/scripts/contato/msg/'.$this->_request->getParam('chave').'.msg';

                if(file_exists($file))
                {
                    $dados = unserialize(file_get_contents($file));
                    if(isset($dados['assunto']))
                    {
                        $assunto = $dados['assunto'];
                    }
                    else
                    {
                        $assunto = 'E-mail enviado através do Portal Uniamérica';
                    }
                    // gambito para não agrupar mensagem no gmail
                    $assunto .= sprintf(' [%s]', time());
                    $lista = explode(',');

                    //enviando a mensagem real
                    $myView = new Zend_View();
                    $myView->addScriptPath(APPLICATION_PATH . '/modules/congresso/views/scripts/contato/');
                    $html_body = $myView->render('email.phtml');
                    $html_body = preg_replace('@\{(\w+)\}@e', '@$dados["$1"]', $html_body);

                    $email = new App_SendMail();
                    $email->send('congresso@uniamerica.br', 'Contato', 'Uniamérica - Congresso - '. date("Ymd-His").' - '.$assunto, $html_body, $dados['email_de'], $dados['email_de'], $dados['nome_de']);
                    $email->send('cpd@uniamerica.br', 'Contato', 'Uniamérica - Congresso - '. date("Ymd-His").' - '.$assunto, $html_body, $dados['email_de'], $dados['email_de'], $dados['nome_de']);

                    //removendo o arquivo e redirecionando
                    @unlink($file);
                    $this->_redirect('/congresso/contato/enviado');
                }
                else
                {   //não confirmado
                    $this->_redirect('/congresso/contato');
                }
            }

    }

    public function EmailConfirmacao( $email, $nome, $telefone, $assunto, $mensagem,  $dias_prazo = 2)
    {

            $chave = md5(uniqid(rand(0, time())));

            $compilada = array(
                    'email_de' => $email,
                    'nome_de' => $nome,
                    'telefone' => $telefone,
                    'assunto' => $assunto,
                    'mensagem' => $mensagem,
                    'chave' => $chave
            );


            $fp = @fopen(APPLICATION_PATH . '/modules/congresso/views/scripts/contato/msg/'.$chave.'.msg', 'w');
            if(!$fp) {
                return false;
            }


            fwrite($fp, serialize($compilada));
            fclose($fp);

            //enviando mensagem de confirmação para o e-mail do usuario
            $myView = new Zend_View();
            $myView->addScriptPath(APPLICATION_PATH . '/modules/congresso/views/scripts/contato/');
            $html_body = $myView->render('confirma.phtml');
            $html_body = preg_replace('@\{(\w+)\}@e', '@$compilada["$1"]', $html_body);

            $email = new App_SendMail();
            $email->send($compilada['email_de'], 'Fale Conosco', 'Uniamérica - Confirmação para envio de mensagem  '. date("Ymd-His"), $html_body, $compilada['email_de'], $compilada['email_de'], $compilada['nome_de']);

            $this->view->dados = $compilada;
            $this->_redirect('/congresso/contato/confirmaenvio');
    }



}
