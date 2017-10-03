<?php

class Admin_Form_Eventos extends Zend_Form
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
    	  	
    	$arquivo = new Zend_Form_Element_File('icone');
    	$arquivo->setLabel('Icone')
    	->addValidator('Size', false, 1024000)
    	->addValidator('Extension', true, 'jpg,jpeg,png,gif')
    	->setDescription('Somente imagens em jpg, jpeg, png ou gif, a imagem será redimensionada para o tamanho 300x225.');
    	$this->addElement($arquivo);
    	    	
    	$dataevento = new Zend_Form_Element_Text('dataevento');
    	$dataevento->setLabel( 'Data do Evento' )
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->setAttrib('class', 'span1')
    	->addValidator('NotEmpty');
    	$this->addElement($dataevento);   

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

