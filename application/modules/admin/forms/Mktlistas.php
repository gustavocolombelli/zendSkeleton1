<?php

class Admin_Form_Mktlistas extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	$this->setAttrib('enctype', 'multipart/form-data');
    	$this->setAttrib('class', 'zend_form');

    	$nome = new Zend_Form_Element_Text('nome');
    	$nome->setLabel( 'nome' )
	    	->setRequired(true)
	    	->addFilter('StripTags')
	    	->addFilter('StringTrim')
	    	->addValidator('NotEmpty')
	    	->setAttrib('class', 'span8');
    	$this->addElement($nome);

        $arquivo = new Zend_Form_Element_File('arquivo');
        $arquivo->setLabel( 'Arquivo' )
            ->setDestination(APPLICATION_PATH .'/tmp')
            ->addValidator('Extension', true, 'csv')
            ->addValidator('Count', true, 1)
            ->setRequired(true)
            ->setDescription('Tamanho máximo para o arquivo de: '. ini_get('upload_max_filesize'))
            ->addValidator('Size', false, 50000000);
        $this->addElement($arquivo);

    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Salvar')
	    	->setAttrib('class', 'btn btn-primary')
	    	->setIgnore(true);
    	$this->addElement($submit);
    }


}

