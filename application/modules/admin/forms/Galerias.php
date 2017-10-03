<?php

class Admin_Form_Galerias extends Zend_Form
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
    	->setAttrib('class', 'span6');
    	$this->addElement($titulo);
    	 
    	$dataevento = new Zend_Form_Element_Text('dataevento');
    	$dataevento->setLabel( 'Data do Evento' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'span2 datepicker');
    	$this->addElement($dataevento);
    	
    	$icone = new Zend_Form_Element_File('icone');
    	$icone->setLabel('Icone')
    	->addValidator('Size', false, 1024000)
    	->addValidator('Extension', false, 'jpg,jpeg,png,gif')
    	->setDescription('Somente imagens em jpg, jpeg, png ou gif.');
    	$this->addElement($icone);    	
    	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Salvar')
    	->setAttrib('class', 'btn btn-primary')
    	->setIgnore(true);
    	$this->addElement($submit);    	
    }


}

