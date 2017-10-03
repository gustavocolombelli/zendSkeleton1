<?php


/**
 * Formatação de Datas
 * Auxiliar da Camada de Visualização
 * @author Paulo Cesar Garcia
 * @see APPLICATION_PATH/views/helpers/Date.php
 */
class Zend_View_Helper_IntToDate extends Zend_View_Helper_Abstract
{
    /**
     * Método Principal
     * @param string $value Valor para Formatação
     * @param string $format Formato de Saída
     * @return string Valor Formatado
     */
    public function IntToDate($value)
    {
        echo sprintf("%s/%s/%s", 
                substr($value, 6, 2),
                substr($value, 4, 2),
                substr($value, 0, 4));
        
    }
}