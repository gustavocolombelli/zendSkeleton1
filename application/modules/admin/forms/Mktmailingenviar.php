<?php

class Admin_Form_Mktmailingenviar extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	$this->setAttrib('enctype', 'multipart/form-data');
    	$this->setAttrib('class', 'zend_form');


        $mensagem = new Zend_Form_Element_Select('codmktmensagensmailing');
        $mensagem->setLabel( 'Mensagem' )
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('NotEmpty');

        $lMensagens = new Application_Model_Mktmensagensmailing();

        foreach ($lMensagens->fetchAll(array('statusreg = ?' => 1), 'assunto') as $item) {
            //$lista->addMultiOption($item['codmktlista'], $item['nome']);
            $mensagem->addMultiOptions(array(
                $item['codmktmensagensmailing']  => $item['assunto']));
        }


        $this->addElement($mensagem);


        $lista = new Zend_Form_Element_MultiCheckbox('lista');
        $lista->setLabel( 'Listas' )
        ->setRequired(true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('NotEmpty')
        ->setSeparator('');
         
        $lListas = new Application_Model_Mktlistas();
        foreach ($lListas->fetchAll(array('statusreg = ?' => 1), 'nome') as $item) {
            $lista->addMultiOption($item['codmktlista'], $item['nome']);
        }
        $this->addElement($lista);   


    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Salvar')
	    	->setAttrib('class', 'btn btn-primary')
	    	->setIgnore(true);
    	$this->addElement($submit);
    }


}

