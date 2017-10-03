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
 *             [_nivel] => 0
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

class App_ArrayRecursivo
{
    public function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();


        foreach ($elements as $element)
        {
            if ($element['parent_id'] == $parentId)
            {
                $children = $this->buildTree($elements, $element['id']);
                if ($children)
                {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }


}
