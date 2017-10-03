<?php

error_reporting(1);
class App_Freq_Freq
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
            $registro['codEquipamento']                     = $this->getPosition($linhaT, 1, 9);
            $registro['codTipo']                            = $this->getPosition($linhaT, 11, 3);
            $registro['identificacao']                      = $this->getPosition($linhaT, 15, 20);
            $registro['datacadastrada']                     = $this->getPosition($linhaT, 36, 10);
            $registro['horacadastrada']                     = $this->getPosition($linhaT, 47, 8);
            $registro['cod1']                               = $this->getPosition($linhaT, 56, 1);
            $registro['cod2']                               = $this->getPosition($linhaT, 58, 1);
            $registro['cod3']                               = $this->getPosition($linhaT, 60, 1);
            $registro['cod4']                               = $this->getPosition($linhaT, 62, 1);
            $registro['cod5']                               = $this->getPosition($linhaT, 64, 3);

            $retorno['equipamento'][] = $registro;
            $indice += 1;
        }
        return $retorno;

    }

}
