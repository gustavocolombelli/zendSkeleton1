<?php

class Admin_Form_Paginas extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post');
    	$this->setAttrib('enctype', 'multipart/form-data');
    	$this->setAttrib('class', 'zend_form');

    	$titulo = new Zend_Form_Element_Text('titulo');
    	$titulo->setLabel( 'Titulo' )
	    	->setRequired(true)
	    	->addFilter('StripTags')
	    	->addFilter('StringTrim')
	    	->addValidator('NotEmpty')
			->setAttrib('class', 'slugOrigem span6');
    	$this->addElement($titulo);
    	
    	$permalink = new Zend_Form_Element_Text('permalink');
    	$permalink->setLabel( 'Permalink' )
	    	->setRequired(true)
	    	->addFilter('StripTags')
	    	->addFilter('StringTrim')
	    	->addValidator('NotEmpty')
    		->setAttrib('class', 'slugDestino span6');
    	$this->addElement($permalink);
    	  	
    	$ordem = new Zend_Form_Element_Text('ordem');
    	$ordem->setLabel( 'Ordem' )
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->setAttrib('class', 'span1')
    	->addValidator('NotEmpty');
    	$this->addElement($ordem);    	
    	
    	$categorias = new Zend_Form_Element_MultiCheckbox('categorias');
    	$categorias->setLabel( 'Categorias' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setSeparator('');
    	 
    	$lCategorias = new Application_Model_Pagpaginascategorias();
    	foreach ($lCategorias->fetchAll(array('tipo = ?' => 2, 'ativo = ?' => 1, 'statusreg = ?' => 1), 'nome') as $item) {
    		$categorias->addMultiOption($item['codpagpaginacategoria'], $item['nome']);
    	}
    	$this->addElement($categorias);    	

    	$texto = new Zend_Form_Element_Textarea('texto');
    	$texto->setLabel( 'Texto' )
	    	->setRequired(true)
	    	->addFilter('StringTrim')
	    	->setAttrib('class', 'editor')
	    	->setAttrib('rows', '5')
	    	->addValidator('NotEmpty');
    	$this->addElement($texto);
    	   	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Salvar')
	    	->setAttrib('class', 'btn btn-primary')
	    	->setIgnore(true);
    	$this->addElement($submit);
   	
    }


}

