<?php

class Admin_Form_Mktmailing extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
    	$this->setAttrib('enctype', 'multipart/form-data');
    	$this->setAttrib('class', 'zend_form');


        $remetentenome = new Zend_Form_Element_Text('remetentenome');
        $remetentenome->setLabel( 'Nome remetente' )
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('class', 'span8');
        $this->addElement($remetentenome);

        $remetenteemail = new Zend_Form_Element_Text('remetenteemail');
        $remetenteemail->setLabel( 'Remetente E-mail' )
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('class', 'span8');
        $this->addElement($remetenteemail);    

        $responderpara = new Zend_Form_Element_Text('responderpara');
        $responderpara->setLabel( 'Responder Para' )
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('class', 'span8');
        $this->addElement($responderpara);              

    	$assunto = new Zend_Form_Element_Text('assunto');
    	$assunto->setLabel( 'Assunto' )
	    	->setRequired(true)
	    	->addFilter('StripTags')
	    	->addFilter('StringTrim')
	    	->addValidator('NotEmpty')
	    	->setAttrib('class', 'span8');
    	$this->addElement($assunto);

        $mensagem = new Zend_Form_Element_Textarea('mensagem');
        $mensagem->setLabel( 'Mensagem' )
        ->addFilter('StringTrim')
        ->addValidator('NotEmpty')
        ->setAttrib('class', 'editor')
        ->setAttrib('rows', '5');
        $this->addElement($mensagem);

        $dataenvio = new Zend_Form_Element_Text('dataenvio');
        $dataenvio->setLabel( 'Data envio' )
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('class', 'span8');
        $this->addElement($dataenvio);

        $horaenvio = new Zend_Form_Element_Text('horaenvio');
        $horaenvio->setLabel( 'Hora envio' )
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('class', 'span8');
        $this->addElement($horaenvio);


    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Salvar')
	    	->setAttrib('class', 'btn btn-primary')
	    	->setIgnore(true);
    	$this->addElement($submit);
    }


}

