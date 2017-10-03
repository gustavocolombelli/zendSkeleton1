<?php

error_reporting(1);
define('ConstBBCNRConvenio', '2571023');


/*
Nome Fantasia = Faculdade União das Américas
Razão Social = Associação Internacional União das Américas
CNPJ = 18.715.633/0001-41
Endereço = Av. Tarquínio Joslin dos Santos, 1000 - Jardim Universitário - CEP 85870-901 - Foz do Iguaçu - PR


Conta no Banco do Brasil
Banco = 001
Agencia = 0140-6
Conta Corrente = 11-6


Convênio para Mensalidades
Convênio = 2570430
Contrato = 19079919
Carteira = 18 (Simples sem Registro)


Convênio para Taxas e Eventos
Convênio: 2571023
Contrato: 19080628
Carteira: 18 (Simples sem Registro)
Variação: 2-7

*/



/**
 * Desmonta arquivo CNAB - 240
 *
 * @package default
 * @author Paulo Cesar Garcia
 **/
class App_Cnab_Cnab
{
    public $dados;

    public function __construct($arquivo)
    {
        $this->dados = $arquivo;
    }

    private function getPosition($value, $start, $length, $dec=0)
    {
        return substr($value, $start-1, $length+$dec);
    }

    private function strToDateInt($str)
    {
        return sprintf("%s%s%s",
            substr($str, 4, 4),
            substr($str, 2, 2),
            substr($str, 0, 2));
    }

    public function processar()
    {
        return $this->RegistrosLote();
    }

    private function RegistrosLote()
    {

        $arquivo = $this->dados;
        $totalLinhas = count($arquivo);
        $nossonumero = array();
        $retorno = array();

        // remove Cabecalho
        unset($arquivo[0]);
        unset($arquivo[1]);

        // remove Rodape
        unset($arquivo[$totalLinhas-1]);
        unset($arquivo[$totalLinhas-2]);

        $indice = 2;
        while ( $indice < count($arquivo)+2) { // o arquivo mais 2 pois foi eliminado o cabecalho e o arquivo continuou com a contagem padrao

            $linhaT = $arquivo[$indice];
            $linhaU = $arquivo[$indice+1];

            $registro = array();
            ############# Segmento T #############
            $registro['STCodigodoBanconaCompensacao']       = $this->getPosition($linhaT, 1, 3);
            $registro['STLotedeServico']                    = $this->getPosition($linhaT, 4, 4);
            $registro['STTipodeRegistro']                   = $this->getPosition($linhaT, 8, 1);
            $registro['STNumeroSequencialRegistronoLote']   = $this->getPosition($linhaT, 9, 5);
            $registro['STSegmentodoRegistroDetalhe']        = $this->getPosition($linhaT, 14, 1);
            $registro['STUsoExclusivoFEBRABANCNAB']         = $this->getPosition($linhaT, 15, 1);
            $registro['STCodigodeMovimentoRetorno']         = $this->getPosition($linhaT, 16, 2);
            $registro['STAgenciaMantenedoradaConta']        = $this->getPosition($linhaT, 18, 5);
            $registro['STDigitoVerificadordaAgencia']       = $this->getPosition($linhaT, 23, 1);
            $registro['STNumerodaContaCorrente']            = $this->getPosition($linhaT, 24, 12);
            $registro['STDigitoVerificadordaConta']         = $this->getPosition($linhaT, 36, 1);
            $registro['STDigitoVerificadordaAgConta']       = $this->getPosition($linhaT, 37, 1);
            $registro['STIdentificacaodoTitulo']            = (int)str_replace(ConstBBCNRConvenio, '', $this->getPosition($linhaT, 38, 20));
            $registro['STCodigodaCarteira']                 = $this->getPosition($linhaT, 58, 1);
            $registro['STNumerodoDocumentodeCobranca']      = $this->getPosition($linhaT, 59, 15);
            $registro['STDatadoVencimentodoTitulo']         = $this->getPosition($linhaT, 74, 8);
            $registro['STValorNominaldoTitulo']             = (int)$this->getPosition($linhaT, 82, 13, 2);
            $registro['STNumerodoBanco']                    = $this->getPosition($linhaT, 97, 3);
            $registro['STAgenciaCobradoraRecebedora']       = $this->getPosition($linhaT, 100, 5);
            $registro['STDigitoVerificadordaAgencia_']      = $this->getPosition($linhaT, 105, 1);
            $registro['STIdentificacaodoTitulonaEmpresa']   = $this->getPosition($linhaT, 106, 25);
            $registro['STCodigodaMoeda']                    = $this->getPosition($linhaT, 131, 2);
            $registro['STTipodeInscricao']                  = $this->getPosition($linhaT, 133, 1);
            $registro['STNumerodeInscricao']                = $this->getPosition($linhaT, 134, 15);
            $registro['STNome']                             = $this->getPosition($linhaT, 149, 40);
            $registro['STNodoContrdaOperacaodeCredito']     = $this->getPosition($linhaT, 189, 10);
            $registro['STValordaTarifaCustas']              = (int)$this->getPosition($linhaT, 199, 13, 2);
            $registro['STIdentificacaoparaR_TC_L_B']        = $this->getPosition($linhaT, 214, 10);
            $registro['STUsoExclusivoFEBRABANCNAB_']        = $this->getPosition($linhaT, 224, 17);

            ############# Segmento U #############
            $registro['SUCodigodoBanconaCompensacao']     = $this->getPosition($linhaU, 1, 3);
            $registro['SULotedeServico']                  = $this->getPosition($linhaU, 4, 4);
            $registro['SUTipodeRegistro']                 = $this->getPosition($linhaU, 8, 1);
            $registro['SUNoSequencialdoRegistronoLote']   = $this->getPosition($linhaU, 9, 5);
            $registro['SUCodSegmentodoRegistroDetalhe']   = $this->getPosition($linhaU, 14, 1);
            $registro['SUUsoExclusivoFEBRABANCNAB']       = $this->getPosition($linhaU, 15, 1);
            $registro['SUCodigodeMovimentoRetorno']       = $this->getPosition($linhaU, 16, 2);
            $registro['SUJurosMultaEncargos']             = (int)$this->getPosition($linhaU, 18, 13, 2);
            $registro['SUDescontoConcedido']              = (int)$this->getPosition($linhaU, 33, 13, 2);
            $registro['SUAbatConcedidoCancel']            = (int)$this->getPosition($linhaU, 48, 13, 2);
            $registro['SUIOFRecolhido']                   = (int)$this->getPosition($linhaU, 63, 13, 2);
            $registro['SUPagoSacado']                     = (int)$this->getPosition($linhaU, 78, 13, 2);
            $registro['SULiquidoSerCreditado']            = (int)$this->getPosition($linhaU, 93, 13, 2);
            $registro['SUOutrasDespesas']                 = (int)$this->getPosition($linhaU, 108, 13, 2);
            $registro['SUOutrosCreditos']                 = (int)$this->getPosition($linhaU, 123, 13, 2);
            $registro['SUDataOcorrencia']                 = $this->strToDateInt($this->getPosition($linhaU, 138, 8));
            $registro['SUDataEfetivacaoCredito']          = $this->strToDateInt($this->getPosition($linhaU, 146, 8));
            $registro['SUCodigoOcorrencia']               = $this->getPosition($linhaU, 154, 4);
            $registro['SUDataOcorrencia_']                = $this->getPosition($linhaU, 158, 8);
            $registro['SUValorOcorrencia']                = (int)$this->getPosition($linhaU, 166, 13, 2);
            $registro['SUComplementoOcorrencia']          = $this->getPosition($linhaU, 181, 30);
            $registro['SUCodBancoCorrespondenteCompens']  = $this->getPosition($linhaU, 211, 3);
            $registro['SUNossoNoBancoCorrespondente']     = $this->getPosition($linhaU, 214, 20);
            $registro['SUUsoExclusivoFEBRABANCNAB_']      = $this->getPosition($linhaU, 234, 7);

            $retorno['boletos'][] = $registro;
            $retorno['nossonumero'][] = $registro['STIdentificacaodoTitulo'];


            $indice += 2;
        }
        return $retorno;

    }

}
