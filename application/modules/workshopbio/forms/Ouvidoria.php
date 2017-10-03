<?php

class Workshopbio_Form_Ouvidoria extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post');
    	$this->setAttrib('name', 'ouvidoria');
    	$this->setAttrib('class', 'formulario');

    	$solicitante = new Zend_Form_Element_Select('solicitante');
    	$solicitante->setLabel( 'Solicitante' )
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty');

    	$solicitante->addMultiOptions(array('' => 'Selecione','1' => 'Aluno','2' => 'Comunidade','3' => 'Funcionário Docente','4' => 'Funcionário Técnico'));
    	$this->addElement($solicitante);

    	$cursos = new Zend_Form_Element_Select('codpagcurso');
    	$cursos->setLabel( 'Curso' )
    	->removeDecorator('label')
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'ocultar');

    	$lCursos = new Application_Model_Acacursos();
    	foreach ($lCursos->fetchAll(array('situacao = ?' => 1, 'statusreg = ?' => 1), 'nomeabreviado') as $item) {
    		$cursos->addMultiOption('', 'Selecione um curso')
    			->addMultiOption($item['codcurso'], $item['nomeabreviado']);
    	}
    	$this->addElement($cursos);

    	$nome = new Zend_Form_Element_Text('nome');
    	$nome->setLabel( 'Nome Completo' )
    		->setRequired(true)
	    	->addFilter('StripTags')
	    	->addFilter('StringTrim')
	    	->addValidator('NotEmpty');
    	$this->addElement($nome);

    	$email = new Zend_Form_Element_Text('email');
    	$email->setLabel( 'E-mail' )
	    	->setRequired(true)
	    	->addFilter('StripTags')
	    	->addFilter('StringTrim')
	    	->addValidator('NotEmpty')
                ->addFilter('StringToLower')
                ->addValidator('EmailAddress');
    	$this->addElement($email);

    	$telefone = new Zend_Form_Element_Text('telefone');
    	$telefone->setLabel( 'Telefone' )
	    	->setRequired(true)
	    	->addFilter('StripTags')
	    	->addFilter('StringTrim')
	    	->addValidator('NotEmpty');
    	$this->addElement($telefone);

    	$relato = new Zend_Form_Element_Textarea('relato');
    	$relato->setLabel( 'Relato' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('rows', '3');
    	$this->addElement($relato);

    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Enviar')
	    	->setIgnore(true)
                ->setAttrib('value', 'Enviar');
    	$this->addElement($submit);

    	$lseguranca = new Zend_Form_Element_Hash('hash', 'no_csrf_foo', array('salt' => 'unique'));
    	$this->addElement($lseguranca);

       foreach($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
       }

    }


}

