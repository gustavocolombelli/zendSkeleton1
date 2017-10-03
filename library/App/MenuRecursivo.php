<?php

/**
 * Monta um array recursivo baseado em um array como se fossem objetos
 * 
 * <code>
 * $teste = array(
 * 	array('nome' => 'ford', 'id' => 1, 'pai' => null),
 * 	array('nome' => 'ford2', 'id' => 2, 'pai' => null),
 * 	array('nome' => 'ford3', 'id' => 3, 'pai' => 2),
 * 	array('nome' => 'ford4', 'id' => 4, 'pai' => 2),
 * 	array('nome' => 'ford5', 'id' => 5, 'pai' => 2),
 * 	array('nome' => 'ford6', 'id' => 6, 'pai' => 3)
 * );
 * 
 * $o = new ArrayRecursivo( $teste,'id','pai');
 * 
 * echo '<pre>';
 * print_r($o->processar());
 * 
 * // saida
 * 
 * Array
 * (
 *     [0] => Array
 *         (
 *             [nome] => ford
 *             [id] => 1
 *             [pai] => 
 *             [_filhos] => Array
 *                 (
 *                 )
 * 
 *       )
 * 
 *     [1] => Array
 *         (
 *             [nome] => ford2
 *             [id] => 2
 *             [pai] => 
 *             [_filhos] => Array
 *                 (
 *                     [0] => Array
 *                         (
 *                             [nome] => ford3
 *                             [id] => 3
 *                             [pai] => 2
 *                             [_filhos] => Array
 *                                 (
 *                                     [0] => Array
 *                                         (
 *                                             [nome] => ford6
 *                                             [id] => 6
 *                                             [pai] => 3
 *                                             [_filhos] => Array
 *                                                 (
 *                                                 )
 * 
 *                                         )
 * 
 *                                 )
 * 
 *                         )
 * 
 *                     [1] => Array
 *                         (
 *                             [nome] => ford4
 *                             [id] => 4
 *                             [pai] => 2
 *                             [_filhos] => Array
 *                                 (
 *                                 )
 * 
 *                         )
 * 
 *                     [2] => Array
 *                         (
 *                             [nome] => ford5
 *                             [id] => 5
 *                             [pai] => 2
 *                             [_filhos] => Array
 *                                 (
 *                                 )
 * 
 *                         )
 * 
 *                 )
 * 
 *         )
 * 
 * )
 * </code>
 *
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */

class App_MenuRecursivo {
	public $nomePropriedadeFilhos = 'pages';
	
	private $result;
	private $lista;
	private $id;
	private $pai;
	private $processados = array();
	
	function __construct(array $lista, $id, $pai )
	{
		$this->result = array();
		$this->lista = $lista;
		$this->id = $id;
		$this->pai = $pai;
	}
	
	public function processar()
	{
		foreach( $this->lista as $item )
		{
			if( empty($item[ $this->pai ]) )
			{
				$item = $this->montar($item);
				$this->result[] = $item;
			}
		}
		
		return $this->result;
	}
	
	public function getFilhos( $id )
	{
		$filhos = array();
		foreach( $this->lista as $k => $item )
		{
			if( $item[ $this->pai ] == $id )
			{
				$filhos[] = $item;
				$this->processados[] = $item;
			}
		}
		
		return $filhos;
	}
	
	private function montar( $item )
	{
		$filhos = $this->getFilhos( $item[ $this->id ] );
		
		$item[ $this->nomePropriedadeFilhos ] = array();
		
		if( count($filhos) > 0 )
		{
			foreach($filhos as $i => $filho)
			{
				$filhos[ $i ] = $this->montar($filho);
			}
			
			$item[$this->nomePropriedadeFilhos] = $filhos;
		}
		
		return $item;
	}
}


?>