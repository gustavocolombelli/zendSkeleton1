<?php

class teste_Form_Cadastro extends Zend_Form
{
    public function init()
    {
        $this->setElementDecorators(array('ViewHelper'));

        $this->addElement('text', 'nome', array(
            'label'         => 'Nome',
            'placeholder'   => 'Nome',
            'id'            => 'nome',
            'class'         => 'form-control capitalize',
            'required'      => '',
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'datanasc', array(
            'label'         => 'Data Nascimento',
             'placeholder'   => 'Data Nascimento',
            'class'         => 'form-control dateBR',
              'required'      => '',
            'validators'  => array (
                array('date', false, array('dd/MM/yyyy'))
            ),
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'email', array(
            'label'         => 'Email',
            'id'            => 'email',
              'placeholder'   => 'Email',
            'class'         => 'form-control',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'cidade', array(
            'label'         => 'Cidade',
            'id'            => 'cidade',
            'placeholder'   => 'Cidade',
            'class'         => 'form-control capitalize',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));


        $this->addElement('text', 'telefone', array(
            'label'         => 'telefone',
            'id'            => 'telefone',
            'placeholder'   => 'Telefone',
            'class'         => 'form-control telefone',
            'required'      => 'required',
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'celular', array(
            'label'         => 'Celular',
            'id'            => 'celular',
            'placeholder'   => 'Celular',
            'class'         => 'form-control telefone',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));



        $this->addElement('text', 'curso', array(
            'id'            => 'curso',
            'placeholder'   => 'Curso',
            'class'         => 'form-control',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));


    }
}

