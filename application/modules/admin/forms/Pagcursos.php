<?php

class Admin_Form_Pagcursos extends Zend_Form
{

    public function init()
    {

    	$this->setMethod('post');
    	$this->setAttrib('enctype', 'multipart/form-data');
    	$this->setAttrib('class', 'zend_form');
    	 
    	$nome = new Zend_Form_Element_Text('nome');
    	$nome->setLabel( 'Nome' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'slugOrigem span6');
    	$this->addElement($nome);
    	 
    	$permalink = new Zend_Form_Element_Text('permalink');
    	$permalink->setLabel( 'Permalink' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'slugDestino span6');
    	$this->addElement($permalink);
    	
    	$icone = new Zend_Form_Element_File('icone');
    	$icone->setLabel('Icone')
    	->addValidator('Size', false, 1024000)
    	->addValidator('Extension', false, 'jpg,jpeg,png,gif');
    	$this->addElement($icone);    	
    	
    	$cursos = new Zend_Form_Element_MultiCheckbox('cursos');
    	$cursos->setLabel( 'Curso' )
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setSeparator(''); 
    	
    	$lCursos = new Application_Model_Acacursos();
    	foreach ($lCursos->fetchAll(array('situacao = ?' => 1, 'statusreg = ?' => 1), 'nomeabreviado') as $item) {
    		$cursos->addMultiOption($item['codcurso'], $item['nomeabreviado']);
    	}
    	$this->addElement($cursos);    
    	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Salvar')
    	->setAttrib('class', 'btn btn-primary')
    	->setIgnore(true);
    	$this->addElement($submit);



    }


}

