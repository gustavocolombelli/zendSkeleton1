<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dateToInt
 *
 * @author paulocesargarcia
 */
class Zend_Controller_Action_Helper_Dates extends Zend_Controller_Action_Helper_Abstract 
{

    /**
     * Converte uma data para número inteiro
     * @param string $data Data a ser convertida
     * @author Hugo Ferreira da Silva
     * @return mixed False em caso de erro e um inteiro em caso de sucesso
     */
    function dataToInt( $data ) {
            $r = array();
            if( !preg_match('@^([0-9]{2})/([0-9]{2})/([0-9]{4})$@', $data, $r)) {
                    return false;
            }
            $int = $r[3] . $r[2] . $r[1];

            return $int;
    }

    /**
     * Converte um inteiro para data
     * @para int $int Inteiro a ser convertido
     * @author Hugo Ferreira da Silva
     * @return mixed Data formatada (string) em caso de sucesso ou false em caso de erro
     */
    function intToData( $int ) {
            $r = array();
            if( !preg_match('@^([0-9]{4})([0-9]{2})([0-9]{2})$@', $int, $r)) {
                    return false;
            }
            $data = $r[3] .'/'. $r[2] .'/'. $r[1];

            return $data;
    }

    function horaToInt( $hora )
    {
            if( !preg_match('@^(\d{2}):(\d{2})$@', $hora, $reg))
            {
                    return 0;
            }

            $minutos = ($reg[1] * 60) + $reg[2];
            return $minutos;
    }

    function intToHora ( $hora )
    {
            $horas     = intval( $hora / 60 );
            $minutos   = $hora - ($horas * 60);
            $formatado = sprintf('%02d:%02d', $horas, $minutos);

            return $formatado;
    }

    /**
     * converte segundos para o formato 00:00:00
     *
     * @param int $pSegundos
     * @return string Segundos formatados
     */
    public function segundosToHora( $pSegundos )
    {
        $horas = sprintf('%d', $pSegundos/3600);
        $minutos = sprintf('%d', ($pSegundos/60)-($horas*60));
        $segundos = $pSegundos%60;

        return sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
    }

    /**
     * converte um formato de hora (00:00:00) em segundos
     *
     * @param string $pHora hora em string
     * @return int Segundos resultantes
     */
    public function horaToSegundos( $pHora )
    {
        if( ! preg_match('@^(\d{2}):(\d{2}):(\d{2})$@', $pHora, $reg) )
        {
            return 0;
        }

        $segundos = ($reg[1]*3600) + ($reg[2]*60) + $reg[3];

        return $segundos;
    }    
    
    /**
     * calcula a diferença de dias entre duas datas no formato de inteiro
     * @param int $data1 Primeira data
     * @param int $data2 Segunda data
     * @return int Diferença em dias
     */
    public function DateDiff( $data1, $data2 )
    {
            if( $data1 < $data2 )
            {
                    $fim    = $data2;
                    $inicio = $data1;
            } else {
                    $fim    = $data1;
                    $inicio = $data2;
            }

            preg_match('@^(\d{4})(\d{2})(\d{2})$@', $inicio, $d1);
            preg_match('@^(\d{4})(\d{2})(\d{2})$@', $fim,    $d2);

            $ts1 = mktime(0,0,0, $d1[2], $d1[3], $d1[1]);
            $ts2 = mktime(0,0,0, $d2[2], $d2[3], $d2[1]);

            $diff = round(($ts2 - $ts1) / (3600*24));
            return $diff;
    }

    /**
     * Gera as datas no intervalo de duas datas passadas, no formato inteiro
     * Exemplo:
     * <code>
     * $datas = Sistema::DatasNoIntervalo( 20080226, 20080310 );
     * print_r( $datas );
     * // result
     * // array( 20080226, 20080227, 20080228, 20080301 .... 20080310 )
     * </code>
     * @param int $pDataInicial Data de inicio do intervalo
     * @param int $pDataFinal Data final do intervalo
     * @return array Array contendo as datas em formato inteiro
     */
    public static function DatasNoIntervalo( $pDataInicial, $pDataFinal )
    {
            $lista = array( $pDataInicial );
            $res1 = preg_match('@^(\d{4})(\d{2})(\d{2})$@', $pDataInicial, $inicial);
            $res2 = preg_match('@^(\d{4})(\d{2})(\d{2})$@', $pDataFinal,   $final);

            if( $res1 == true && $res2 == true && $pDataFinal >= $pDataInicial )
            {
                    $timestamp_inicial = mktime(0, 0, 0, $inicial[2], $inicial[3], $inicial[1]);
                    $timestamp_final   = mktime(0, 0, 0, $final[2],   $final[3],   $final[1]);

                    while( $timestamp_inicial < $timestamp_final )
                    {
                            $timestamp_inicial += 24 * 3600; // um dia
                            $lista[] = date('Ymd', $timestamp_inicial);
                    }
            }

            $lista[] = $pDataFinal;

            return $lista;
    }

    /**
     * Adiciona dias a uma determinada data
     * @param int $data Data base
     * @param int $dias Quantidade de dias a serem adicionados
     * @return int Nova data com o intervalo adicionado
     */
    public function addDias( $data, $dias )
    {
            preg_match('@^(\d{4})(\d{2})(\d{2})$@', $data, $partes);

            $intervalo = mktime(0, 0, 0, $partes[2], $partes[3]+$dias, $partes[1]);
            $novadata = date('Ymd', $intervalo);
            return $novadata;
    }

    /**
     * Adiciona Meses a uma determinada data
     * @param int $data Data base
     * @param int $meses Quantidade de meses a serem adicionados
     * @return int Nova data com o intervalo adicionado
     */
    public function addMeses( $data, $meses )
    {
            preg_match('@^(\d{4})(\d{2})(\d{2})$@', $data, $partes);
            $intervalo = mktime(0,0,0,$partes[2]+$meses, $partes[3], $partes[1]);
            $novadata = date('Ymd', $intervalo);
            return $novadata;
    }

    /**
     * Adiciona anos a uma determinada data
     * @param int $data Data base
     * @param int $anos Quantidade de anos a serem adicionados
     * @return int Nova data com o intervalo adicionado
     */
    public function addAnos( $data, $anos )
    {
            preg_match('@^(\d{4})(\d{2})(\d{2})$@', $data, $partes);
            $intervalo = mktime(0,0,0,$partes[2], $partes[3], $partes[1] + $anos);
            $novadata = date('Ymd', $intervalo);
            return $novadata;
    }        
    
    
}
