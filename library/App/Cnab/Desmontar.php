<?php


define('ConstCNRAgencia', 111);
define('ConstCNRConvenio', 111);
define('ConstCNRAgenciaDV', 111);
define('ConstCNRContaDV', 111);
define('ConstCNRConta', 111);
define('ConstCNRNome', 111);



/**
 * Desmonta arquivo CNAB - 240
 *
 * @package default
 * @author Paulo Cesar Garcia
 **/
class App_Cnab_Desmontar
{
    private $dados;

    public function __construct($arquivo)
    {
        $this->dados = explode("\n", $arquivo);
    }

    private function limparDados()
    {
        $dados = array();
        foreach ($this->dados as $key => $value)
        {
            if(trim($value)) {
                $dados[$key] = $value;
            }
        }
        $this->dados = $dados;
    }

    public function processar()
    {
        $this->limparDados();

        // Verifica se o Arquivo esta vazio.
        if (!is_array($this->dados)) return 'Arquivo vazio';

        // Validar o Cabecalho do Arquivo, para ver se eh arquivo de retorno e se eh do convenio de eventos.
        if (is_string($this->ValidarCabecalhoArquivo())) return 'Erro ao ler o cabeçalho';
echo 'ss'; die;


    }

    private function ValidarCabecalhoArquivo()
    {

        $Result     = false;
        $lRegistro  = $this->dados[0];

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Codigo do Banco na Compensacao
        //    INTERVALO: 1 a 3 (3)
        //    CONTEUDO: Númerico igual a "001"
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 1-1, 3 );
        if ($str <> '001') return 'Cabecalho do Arquivo: Código do Banco de Compensação incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Lote do Servico
        //    INTERVALO: 4 a 7 (4)
        //    CONTEUDO: Númerico igual a "0000"
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 4-1, 4 );
        if($str <> '0000') return 'Cabecalho do Arquivo: Lote de Serviço incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Tipo de Registro
        //    INTERVALO: 8 a 8 (1)
        //    CONTEUDO: Númerico igual a "0"
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 8-1, 1 );
        if($str <> '0') return 'Cabecalho do Arquivo: Tipo do Registro incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Uso exclusivo FEBRABAN / CNAB
        //    INTERVALO: 9 a 17 (9)
        //    CONTEUDO: Alfanumerico a ""
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 9-1, 9 );
echo $str; die;
        if(trim( $str ) <> '') return 'Cabecalho do Arquivo: Campo Exclusivo FEBRABAN incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Tipo de Inscricao da Empresa
        //    INTERVALO: 18 a 18 (1)
        //    CONTEUDO: Numerico - 1 para CPF e 2 para CNPJ
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 18-1, 1 );
        if($str <> '2') return 'Cabecalho do Arquivo: Tipo de inscrição da Empresa incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Numero de Inscricao da Empresa
        //    INTERVALO: 19 a 32 (14)
        //    CONTEUDO: CPF ou CNPJ da Empresa
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 19-1, 14 );
        if ($str <> ConstCNRAgencia ) return 'Cabecalho do Arquivo: CNPJ da Empresa incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Numero do Convenio de Cobranca BB
        //    INTERVALO: 33 a 41 (9)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 33-1, 9 );
        if ($str<> ConstCNRAgencia ) return 'Cabecalho do Arquivo: Número do convênio de cobrança incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Cobranca Cedente BB
        //    INTERVALO: 42 a 45 (4)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 42-1, 4 );
        if ($str <> '0014') return 'Cabecalho do Arquivo: Cobrança do Cedente incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Numero da carteira de cobranca BB
        //    INTERVALO: 46 a 47 (2)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 46-1, 2 );
        if (trim( $str ) <> '') return 'Cabecalho do Arquivo: Número da carteira de cobrança BB incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Numero da variacao da carteira de cobranca BB
        //    INTERVALO: 48 a 50 (3)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 48-1, 3 );
        if (trim( $str ) <> '') return 'Cabecalho do Arquivo: Número da variação da carteira de cobrança BB incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Campo reservado BB
        //    INTERVALO: 51 a 52 (2)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 51-1, 2 );
        if (trim( $str ) <> '') return 'Cabecalho do Arquivo: Campo reservado BB incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Agencia Mantenedora da Conta
        //    INTERVALO: 53 a 57 (5)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 53-1, 5 );
        if ($str <>  ConstCNRAgencia) return 'Cabecalho do Arquivo: Agência Mantenedora da Conta incorreta.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Digito Verificador da Agencia
        //    INTERVALO: 58 a 58 (1)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 58-1, 1 );
        if ($str <> substr( ConstCNRAgenciaDV, Length( ConstCNRAgenciaDV ), 1 ) ) return 'Cabecalho do Arquivo: Dígito Verificador da Agência incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Número da Conta Corrente
        //    INTERVALO: 59 a 70 (12)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 59-1, 12 );
        if ($str <> ConstCNRConta) return 'Cabecalho do Arquivo: Número da Conta Corrente incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Digito Verificador da Conta
        //    INTERVALO: 71 a 71 (1)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 71-1, 1 );
        if ($str <> substr( ConstCNRContaDV, strlen( ConstCNRContaDV ), 1 )) return 'Cabecalho do Arquivo: Dígito Verificador da Conta incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Dígito Verificador da Agencia e Conta
        //    INTERVALO: 72 a 72 (1)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 72-1, 1 );
        if (trim( $str ) <> '') return 'Cabecalho do Arquivo: Dígito Verificador da Agência e Conta incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Nome da Empresa
        //    INTERVALO: 73 a 102 (30)
        //    CONTEUDO: Alfanumerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 73-1, 30 );
        if (trim( $str ) <> trim( substr( ConstCNRNome ), 1, 30 ) ) return 'Cabecalho do Arquivo: Nome da Empresa incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Nome do Banco
        //    INTERVALO: 103 a 132 (30)
        //    CONTEUDO: Alfanumerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 103-1, 30 );
        if (trim( $str ) <> trim( 'BANCO DO BRASIL' )) return 'Cabecalho do Arquivo: Nome do Banco incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Uso exclusivo FEBRABAN / CNAB
        //    INTERVALO: 133 a 142 (10)
        //    CONTEUDO: Alfanumerico a ""
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 133-1, 10 );
        if (trim( $str ) <> '') return 'Cabecalho do Arquivo: Campo Exclusivo FEBRABAN incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Codigo Remessa / Retorno
        //    INTERVALO: 143 a 143 (1)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 143-1, 1 );
        if ($str <> '2') return 'Cabecalho do Arquivo: Código Remessa/Retorno incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Data de Geracao do Arquivo
        //    INTERVALO: 144 a 151 (8)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 144-1, 8 );
        $str = substr_replace($str, "/", 5, 0);
        $str = substr_replace($str, "/", 3, 0);

        if (!$this->FncValidarData( $str )) return 'Cabecalho do Arquivo: Data de Geração do Arquivo incorreta.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Hora de Geracao do Arquivo
        //    INTERVALO: 152 a 157 (6)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 152-1, 6 );
        if (!FncIntToHora( $str )) return 'Cabecalho do Arquivo: Hora de Geração do Arquivo incorreta.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Numero sequencia do arquivo
        //    INTERVALO: 158 a 163 (6)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 158-1, 6 );
        if ( !FncPossuiSomenteNumeros( $str )  || ( $str  <= 0 )) return 'Cabecalho do Arquivo: Número sequencial do arquivo incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Numero da versao do layout do arquivo
        //    INTERVALO: 164 a 166 (3)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 164-1, 3 );
        if ($str <> '030') return 'Cabecalho do Arquivo: Número da versão do layout do arquivo incorreto.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Densidade da gravacao do arquivo
        //    INTERVALO: 167 a 171 (5)
        //    CONTEUDO: Numerico
        //------------------------------------------------------------------------------------------------
        $str = substr( $lRegistro, 167-1, 5 );
        if ($str <> '00000') return 'Cabecalho do Arquivo: Densidade da gravação do arquivo incorreta.';

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Para uso reservado do Banco
        //    INTERVALO: 172 a 191 (20)
        //    CONTEUDO: Alfanumerico
        //------------------------------------------------------------------------------------------------
        //    Nao tratado, porque nao importa.

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Para uso reservado da Empresa
        //    INTERVALO: 192 a 211 (20)
        //    CONTEUDO: Alfanumerico
        //------------------------------------------------------------------------------------------------
        //    Nao tratado, porque nao importa.

        //------------------------------------------------------------------------------------------------
        //    CAMPO: Uso exclusivo FEBRABAN / CNAB
        //    INTERVALO: 212 a 240 (29)
        //    CONTEUDO: Alfanumerico
        //------------------------------------------------------------------------------------------------
        //    Nao tratado, porque nao importa.

        $Result = True;
        return $Result;
    }

    private function FncValidarData($value)
    {
        return true;
        # code...
    }

    private function FncPossuiSomenteNumeros($value)
    {
        return true;
    }


} // END class App_Cnab_Desmontar