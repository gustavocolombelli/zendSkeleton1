<?php
class Default_IndexController extends Zend_Controller_Action
{


    public function testeAction(){
	  $telefone = '554599415891';
          $pass = (md5('uniamerica'));
          $token = (md5($telefone.$pass));
            // ---------------------------------------------------------------------------------------
            //--------------------- Sms----------------------------------------
            //---------------------------------------------------------------------------------------
            
            $dadosProcessados = array(
                "telefone" =>  $telefone,
                "mensagem" =>  'Funciona plox',
                "situacao" =>  "0",
                "datacriacao" => date('Y-m-d H:i:s'),
                "dataenvio" => date('Y-m-d H:i:s'),
                "token" =>  $token,
            );
            $body = json_encode($dadosProcessados);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://intranet.uniamerica.br/api/sms/put");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: OAuth 2.0 token here"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $result = curl_exec($ch);

	die('rodou');

    }


    public function blackboardAction(){
	
             $atena = new Application_Model_Atena_CarteirinhasDbt();
echo '<pre>';


        // Roda as funcoes
	$sql = "select fn_bla_person_pos_add()";
	$atena->getAdapter()->query($sql);

	$sql = "select fn_bla_course_pos_add()";
	$atena->getAdapter()->query($sql);

	$sql = "select fn_bla_enrollments_pos_add()";
	$atena->getAdapter()->query($sql);



        $sql = "select fn_bla_person_add(20161)";
        $atena->getAdapter()->query($sql);
        $sql = "select fn_bla_course_add(20161)";
        $atena->getAdapter()->query($sql);
        $sql = "select fn_bla_enrollments_add(20161)";
        $atena->getAdapter()->query($sql);

        // Cadastro de pessoas
        $sql = "SELECT * FROM bla_person WHERE situacao_curl = 0";
        $lista = $atena->getAdapter()->query($sql)->fetchAll();

        if(count($lista))
        {
            $caminhoArquivo = APPLICATION_PATH. "/tmp/person.txt";
            $gerarArquivo = fopen($caminhoArquivo, "w");
            fwrite($gerarArquivo, "external_person_key|firstname|lastname|user_id|email|passwd|pwencryptiontype\n");

            foreach($lista as $item) {

                $txt = sprintf("%s|%s|%s|%s|%s|%s|%s\n",
                    $item['external_person_key'],
                    $item['firstname'],
                    $item['lastname'],
                    $item['user_id'],
                    $item['email'],
                    $item['passwd'],
                    $item['pwencryptiontype']);

                $enc = mb_detect_encoding($txt);

                $data = mb_convert_encoding($txt, "ISO-8859-1", $enc);


                fwrite($gerarArquivo, $data);
            }
            fclose($gerarArquivo);

            $url = "https://uniamerica.blackboard.com/webapps/bb-data-integration-flatfile-BBLEARN/endpoint/person/store";
            $this->curl($caminhoArquivo, $url);
        }

        // Cadastro de cursos
        $sql = "SELECT * FROM bla_course WHERE situacao_curl = 0";
        $lista = $atena->getAdapter()->query($sql)->fetchAll();

        if(count($lista))
        {
            $caminhoArquivo = APPLICATION_PATH. "/tmp/course.txt";
            $gerarArquivo = fopen($caminhoArquivo, "w");
            fwrite($gerarArquivo, "external_course_key|course_id|course_name|term_key|data_source_key|row_status\n");

            foreach($lista as $item) {

                $txt = sprintf("%s|%s|%s|%s|%s|%s\n",
                    $item['external_course_key'],
                    $item['course_id'],
                    $item['course_name'],
                    $item['term_key'],
                    $item['data_source_key'],
                    $item['row_status']
                );

                $enc = mb_detect_encoding($txt);
                $data = mb_convert_encoding($txt, "ISO-8859-1", $enc);

                fwrite($gerarArquivo, $data);
            }
            fclose($gerarArquivo);

            $url = "https://uniamerica.blackboard.com/webapps/bb-data-integration-flatfile-BBLEARN/endpoint/course/store";
            $this->curl($caminhoArquivo, $url);
        }

        // Cadastro de bla_enrollments
        $sql = "SELECT * FROM bla_enrollments WHERE situacao_curl = 0";
        $lista = $atena->getAdapter()->query($sql)->fetchAll();

        if(count($lista))
        {
            $caminhoArquivo = APPLICATION_PATH. "/tmp/enrollments.txt";
            $gerarArquivo = fopen($caminhoArquivo, "w");
            fwrite($gerarArquivo, "external_person_key|external_course_key|data_source_key|role|row_status\n");

            foreach($lista as $item) {

                $txt = sprintf("%s|%s|%s|%s|%s\n",
                    $item['external_person_key'],
                    $item['external_course_key'],
                    $item['data_source_key'],
                    $item['role'],
		    $item['row_status']
                );

                $enc = mb_detect_encoding($txt);
                $data = mb_convert_encoding($txt, "ISO-8859-1", $enc);

                fwrite($gerarArquivo, $data);
            }
            fclose($gerarArquivo);

            $url = "https://uniamerica.blackboard.com/webapps/bb-data-integration-flatfile-BBLEARN/endpoint/membership/store";
            $this->curl($caminhoArquivo, $url);
        }


        // Roda updates para nao cadastrar novamente
        $sql = "update bla_person set situacao_curl = 1 where situacao_curl = 0;";
        $atena->getAdapter()->query($sql);
        $sql = "update bla_course set situacao_curl = 1 where situacao_curl = 0;";
        $atena->getAdapter()->query($sql);
        $sql = "update bla_enrollments set situacao_curl = 1 where situacao_curl = 0;";
        $atena->getAdapter()->query($sql);


        die('Fim do Arquivo');
    }

    private function curl($caminhoArquivo, $url){


        $user = "eac6ce45-d524-4971-8d95-8df9b27b63df";
        $pass = "Vbo93J2gTdf";


    // Initialize cURL
    $ch = curl_init();

    // Set URL on which you want to post the Form and/or data
    curl_setopt($ch, CURLOPT_URL, $url);

    // Set username/password
    curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);

    // Data+Files to be posted
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:text/plain','Content-Length:'.filesize($caminhoArquivo)));
    curl_setopt($ch, CURLOPT_POSTFIELDS, join(file($caminhoArquivo),''));

    // Pass TRUE or 1 if you want to wait for and catch the response against the request made
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // For Debug mode; shows up any error encountered during the operation
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    // HTTPS:
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    // Execute the request and gather some information
    #$result['VER'] = curl_version();
    $result['EXE'] = curl_exec($ch);
    $result['arquivo'] = $caminhoArquivo;
    #$result['INF'] = curl_getinfo($ch);
    $result['ERR'] = curl_error($ch);

    // Just for debug to see response
    echo '<pre>'; print_r($result); echo '</pre>';







    }



    public function indexAction()
    {
        $pessoa = new Application_Model_Unimestre_PessoasDbt();
        $sql = 'SELECT
p.cd_pessoa,
p.nm_pessoa,
m.curso,
cm.DS_CURSO,
mp.sn_finalizado,
m.turma,
me.valoremaberto,
mp.sn_finalizado,
IF( me.valoremaberto = 0, "Sim", "Não") AS pagouparcela1
FROM matriculas m

LEFT JOIN ( SELECT m1.codigoaluno,
m1.anosemestre,
sum( if( m1.situacao IN ( 0, 1, 6 ) or m1.cd_resp = 17000, m1.valorbruto, 0 ) ) as valorpago,
sum( if( m1.situacao in (2, 10) and m1.cd_resp <> 17000, m1.valorbruto, 0 ) ) as valoremaberto
FROM mensalidades m1
WHERE m1.parcela = 1 And m1.anosemestre = 20151
GROUP BY m1.codigoaluno, m1.anosemestre
) me
ON me.codigoaluno = m.codigoaluno
and me.anosemestre = m.anosemestre
LEFT JOIN mol_processos_pessoas mp ON m.codigoaluno = mp.cd_pessoa AND mp.cd_processo = 2
INNER JOIN pessoas p ON p.cd_pessoa = m.codigoaluno
INNER JOIN cursos_mestre cm ON cm.CD_CURSO = m.curso
WHERE
m.codigoaluno = "'.$_SESSION['PORTAL_cd_pessoa'].'"
AND m.anosemestre = 20151
AND m.situacao in (1, 10)
';


        $this->view->pessoas = $pessoa->getAdapter()->query($sql)->fetchAll();

    }

  public function teste1Action()
    {

     $user = 12891;
     $timestamp = strtotime("now");
     $auth = $timestamp . $user . "h7bs8tb";
     $mac = md5($auth);
     $domain = "http://uniamerica.blackboard.com";

     $blackboard = $domain."/webapps/bbgs-autosignon-BBLEARN/autoSignon.do?timestamp=".$timestamp."&userId=".$user."&auth=".$mac."&forward=".$domain;
	
 	echo "
<script>
window.location.href = '".$blackboard."' ;
</script>";
die();
    }




}

