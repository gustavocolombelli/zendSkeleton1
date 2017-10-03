<?php

class teste_IndexController extends Zend_Controller_Action
{

    private $_contador;
    public function init()
    {
        $this->_contador = new Application_Model_Sgrlcontadores();
    }
    
    public function addDias( $data, $dias )
    {
        preg_match('@^(\d{4})(\d{2})(\d{2})$@', $data, $partes);

        $intervalo = mktime(0, 0, 0, $partes[2], $partes[3]+$dias, $partes[1]);
        $novadata = date('Ymd', $intervalo);
        return $novadata;
    }

    public function indexAction()
    {
      $r = 'aaaaa';

        $this->view->teste = $r;

    }

    public function aaaaAction()
    {

        $cursos = new Application_Model_DbTable_Prscursos();
        $sql = 'select * from siga.prs_candidatos c where c.codprsprocessoseletivo = 40 and c.codgrlpessoa = 0 and c.codprscurso = 1058 limit 2500';

        $lCursos = $cursos->getAdapter()->query($sql)->fetchAll();


        foreach ($lCursos as $key => $value)
        {


            $pessoaMdl = new Application_Model_Unimestre_PessoasMdl;
            $value['pais'] = 10;
            #$value['sexo'] = 1;


            $civil = array(3 => 2,
                5 => 3,
                4 => 4,
                1 => 1,
                2 => 6,
                6 => 5);
            if (!empty($value["codestadocivil"])) {
                $value["codestadocivil"] = $civil[$value['codestadocivil']];
            } else {
                $value["codestadocivil"] = strlen($value['codestadocivil']) ? $value['codestadocivil'] : 'NULL';
            }



            if ($value['sexo'] == 1) {
                $value['sexo'] = 'M';
            } elseif ($value['sexo'] == 2) {
                $value['sexo'] = 'F';
            }

            $codgrlpessoa = $pessoaMdl->AddPessoa($value);

            $dadosProcessados = array(
                "codprscandidato" => $value['codprscandidato'],
                "codgrlpessoa" => $codgrlpessoa,
                "dataalteracao" => date("Ymd")
            );

            $candidato = new Application_Model_Prscandidatos();


            if (!empty($value['codprscandidato'])) {
                $candidato->_update($dadosProcessados);
            }


            echo $value['nome'].'<br>';
        }

        die('Feito');

     
    }



     public function Email($dados) {


            $usuario = new Application_Model_DbTable_Sgrlacessovestibular();
            $sql = sprintf("SELECT
                                c.nome,
                                c.datanasc,
                                c.cidade,
                                c.celular,
                                c.telefone,
                                c.email,
                                c.curso,
                                c.datacadastro,
                                msg.curso as nomecurso,
                                msg.msg
                                FROM grl_acessovestibular c
                                INNER JOIN grl_vestibularmsg msg ON c.curso = msg.codvestibularmsg and msg.statusreg = 1
                                WHERE
                                c.email ='%s' ",
                            $dados['email']);

            $rs = $usuario->getAdapter()->query($sql)->fetch();



          $html_body = preg_replace('@\{(\w+)\}@e', '@$rs["$1"]', $rs['msg']);

            $email = $dados['email'];
            $name = $dados['nome'];
            $pass = (md5('uniamerica'));
            $token = (md5($email.$name.$pass));

            $dadosProcessados = array(
                "toemail" =>  $email,
                "toname" =>  $name,
                "subject" => "Inscreva-se no Vestibular Uniamérica",
                "msg" =>  $html_body,
                "html" =>  "0",
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

      }

}


