<?php

class Admin_Form_Login extends Zend_Form
{
	
    public function init()
    {
		$this->setName('login');
        $this->setAttrib('class', 'zend_form');
            
        $usuario = new Zend_Form_Element_Text('login');
        $usuario->setLabel( 'Login:' )
        	->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		$this->addElement($usuario);

        $senha = new Zend_Form_Element_Password('senha');
        $senha->setLabel( 'Senha:' )
        	->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
		$this->addElement($senha);
            
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Entrar')
	    	->setAttrib('class', 'btn btn-primary')
	    	->setIgnore(true);
    	$this->addElement($submit);
            
    }


}

