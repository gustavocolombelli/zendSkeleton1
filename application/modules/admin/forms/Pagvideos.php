<?php

class Admin_Form_Pagvideos extends Zend_Form
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
    	
    	$video = new Zend_Form_Element_Text('video');
    	$video->setLabel( 'Video' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'span3');
    	$this->addElement($video);
    	
    	$arquivo = new Zend_Form_Element_File('arquivo');
    	$arquivo->setLabel('Icone')
    	->addValidator('Size', false, 1024000)
    	->addValidator('Extension', false, 'jpg,jpeg,png,gif')
    	->setDescription('Somente imagens em jpg, jpeg, png ou gif, a imagem será redimensionada para o tamanho 300x225.');
    	$this->addElement($arquivo);
    	
    	$categorias = new Zend_Form_Element_MultiCheckbox('categorias');
    	$categorias->setLabel( 'Categorias' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setSeparator('');
    	 
    	$lVideosCategorias = new Application_Model_Pagvideoscategorias();
    	foreach ($lVideosCategorias->fetchAll(array('ativo = ?' => 1, 'statusreg = ?' => 1), 'nome') as $item) {
    		$categorias->addMultiOption($item['codpagvideocategoria'], $item['nome']);
    	}
    	$this->addElement($categorias);
    	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Salvar')
	    	->setAttrib('class', 'btn btn-primary')
	    	->setIgnore(true);
    	$this->addElement($submit); 
    }


}

