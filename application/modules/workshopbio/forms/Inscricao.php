<?php

class Workshopbio_Form_Inscricao extends Zend_Form
{

    public function init()
    {
        $this->setElementDecorators(array('ViewHelper'));


        $this->addElement('text', 'nome', array(
            'label'         => 'Nome',
            'class'         => 'form-control',
            // 'placeholder'   => 'Nome',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));



        $EmailExists = new Zend_Validate_Db_NoRecordExists(
            array(
                'table' => 'siga.grl_pessoas',
                'field' => 'email',
            )

        );

        $this->addElement('text', 'email', array(
            'label'         => 'E-mail',
            'class'         => 'form-control',
            // 'placeholder'   => 'Email',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
 //         'validators' => array(
  //              $EmailExists, 'EmailAddress',
  //          ),

        ));

        $this->addElement('text', 'nascimentodata', array(
            'label'         => 'Data de Nascimento',
            'class'         => 'form-control',
            // 'placeholder'   => 'Data de Nascimento',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('select', 'sexo', array(
            'label'         => 'Sexo',
            'class'         => 'form-control',
            'multiOptions'  => array(
                '' => '',
                '1' => 'Masculino',
                '2' => 'Feminino'
            ),
            'required'      => true
        ));

        $this->addElement('select', 'codestadocivil', array(
            'label'         => 'Estado Civil',
            'class'         => 'form-control',
            'multiOptions'  => array(
                '' => '',
                '1' => 'Solteiro',
                '2' => 'Casado',
                '3' => 'Divorciado',
                '4' => 'Separado',
                '5' => 'Viúvo',
                '6' => 'União Estável'
            ),
        //    'required'      => true
        ));

        $this->addElement('text', 'logradouro', array(
            'label'         => 'Endereço',
            'class'         => 'form-control',
            // 'placeholder'   => 'Seu Endereço',
         //   'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'numero', array(
            'label'         => 'Numero',
            'class'         => 'form-control',
            // 'placeholder'   => 'Seu Numero',
         //   'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'complemento', array(
            'label'         => 'Complemento',
            'class'         => 'form-control',
            // 'placeholder'   => 'Seu Numero',
          //  'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'bairro', array(
            'label'         => 'Bairro',
            'class'         => 'form-control',
            // 'placeholder'   => 'Bairro',
        //    'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));
        $this->addElement('text', 'cidade', array(
            'label'         => 'Cidade',
            'class'         => 'form-control',
            // 'placeholder'   => 'Cidade',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('select', 'estado', array(
            'label'         => 'UF',
            'class'         => 'form-control',
            'multiOptions'  => array(
                '' => '',
                'AC' => 'Acre',
                'AL' => 'Alagoas',
                'AM' => 'Amazonas',
                'AP' => 'Amapá',
                'BA' => 'Bahia',
                'CE' => 'Ceará',
                'DF' => 'Distrito Federal',
                'ES' => 'Espírito Santo',
                'GO' => 'Goiás',
                'MA' => 'Maranhão',
                'MG' => 'Minas Gerais',
                'MS' => 'Mato Grosso do Sul',
                'MT' => 'Mato Grosso',
                'PA' => 'Pará',
                'PB' => 'Paraíba',
                'PE' => 'Pernambuco',
                'PI' => 'Piauí',
                'PR' => 'Paraná',
                'RJ' => 'Rio de Janeiro',
                'RN' => 'Rio Grande do Norte',
                'RO' => 'Rondônia',
                'RR' => 'Roraima',
                'RS' => 'Rio Grande do Sul',
                'SC' => 'Santa Catarina',
                'SE' => 'Sergipe',
                'SP' => 'São Paulo',
                'TO' => 'Tocantis'
            ),
            'required'      => true
        ));

        $this->addElement('text', 'pais', array(
            'label'         => 'Pais',
            'class'         => 'form-control',
            // 'placeholder'   => 'Pais',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'cep', array(
            'label'         => 'CEP',
            'class'         => 'form-control',
            // 'placeholder'   => 'CEP',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));
        $this->addElement('text', 'identidade', array(
            'label'         => 'N° Identidade',
            'class'         => 'form-control',
            // 'placeholder'   => 'N° Identidade',
       //     'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'cpf', array(
            'label'         => 'CPF',
            'class'         => 'form-control',
            // 'placeholder'   => 'CPF',
        //    'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'telcel', array(
            'label'         => 'Celular',
            'class'         => 'form-control',
            // 'placeholder'   => 'Celular',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'telres', array(
            'label'         => 'Telefone',
            'class'         => 'form-control',
            // 'placeholder'   => 'Telefone',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('text', 'telcom', array(
            'label'         => 'Telefone Comercial',
            'class'         => 'form-control',
            // 'placeholder'   => 'Telefone Comercial',
            'required'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));


        $this->addElement('text', 'ra', array(
            'label'         => 'RA',
            'class'         => 'form-control',
            'id'            => 'ra',
            // // 'placeholder'   => 'RA',
            'disable'      => true,
            'filters'       => array('StringTrim', 'StripTags')
        ));

        $this->addElement('select', 'tipo', array(
            'label'         => 'Tipo',
            'class'         => 'form-control',
            'id'            => 'tipo',
            'multiOptions'  => array(
                '' => '',
                '1022' => 'Alunos ou Egressos',
                '1023' => 'Demais Participantes'
            ),
            'required'      => true
        ));


    }


}

