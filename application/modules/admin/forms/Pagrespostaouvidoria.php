<?php

class Admin_Form_Pagrespostaouvidoria extends Zend_Form
{

    public function init()
    {

    	$this->setMethod('post');
    	$this->setAttrib('name', 'ouvidoria');
    	$this->setAttrib('class', 'formulario');
    	
    	$resposta = new Zend_Form_Element_Textarea('resposta');
    	$resposta->setLabel( 'Resposta' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
	    ->setAttrib('class', 'editor')
	    ->setAttrib('rows', '5');
    	$this->addElement($resposta);
    	 
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Gravar')
    	->setIgnore(true)
    	->setAttrib('value', 'Gravar')
    	->setAttrib('class', 'btn btn-large');
    	$this->addElement($submit);
    	 
    	foreach($this->getElements() as $element) {
    		$element->removeDecorator('HtmlTag');
    		$element->removeDecorator('DtDdWrapper');
    		
    	}    	
    	
    }


}

