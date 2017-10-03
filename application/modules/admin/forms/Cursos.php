<?php

class Admin_Form_Cursos extends Zend_Form
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
    	
    	$codpai = new Zend_Form_Element_Select('codpai');
    	$codpai->setLabel( 'Menu' )
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty');
    	 
    	$paginas = new Application_Model_Pagpaginas();
    	$codpai->addMultiOption('', '');
    	foreach ($paginas->fetchAll(array('statusreg = ?' => 1, 'ativo = ?' => 1, 'codpagtipopagina = ?' => 1), 'titulo') as $item){
    		$codpai->addMultiOption($item['codpagpagina'], $item['titulo']);
    	}
    	$this->addElement($codpai);
    	 
    	$icone = new Zend_Form_Element_File('icone');
    	$icone->setLabel('Icone')
    	->addValidator('Size', false, 1024000)
    	->addValidator('Extension', false, 'jpg,jpeg,png,gif');
    	$this->addElement($icone);    	
    	
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

