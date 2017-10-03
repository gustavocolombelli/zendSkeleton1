<?php

class Admin_Form_Cursospaginas extends Zend_Form
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
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'span1');
    	$this->addElement($ordem);
    	 
    	$destino = new Zend_Form_Element_Text('destino');
    	$destino->setLabel( 'Destino' )
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'span6');
    	$this->addElement($destino);
    	 
    	$texto = new Zend_Form_Element_Textarea('texto');
    	$texto->setLabel( 'Texto' )
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'editor')
    	->setAttrib('rows', '5');
    	$this->addElement($texto);
    	 
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Salvar')
    	->setAttrib('class', 'btn btn-primary')
    	->setIgnore(true);
    	$this->addElement($submit);
    	
    	
    	
    }


}

