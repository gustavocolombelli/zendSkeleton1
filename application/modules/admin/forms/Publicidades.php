<?php

class Admin_Form_Publicidades extends Zend_Form
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
    	
    	
    	$codpagpublicidadetipo = new Zend_Form_Element_Select('codpagpublicidadetipo');
    	$codpagpublicidadetipo->setLabel( 'Tipo' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty');
    	
    	$lPublicidadesTipos = new Application_Model_Pagpublicidadestipos();
    	$lPublicidadesTiposRs = $lPublicidadesTipos->fetchAll(array('statusreg = ?' => 1, 'ativo = ?' => 1), 'nome');
    	
    	$codpagpublicidadetipo->addMultiOption('', 'Selecione');
    	foreach ($lPublicidadesTiposRs as $item){
    		$codpagpublicidadetipo->addMultiOption($item['codpagpublicidadetipo'], $item['nome']);
    	}    	
    	$this->addElement($codpagpublicidadetipo);    	

    	$janela = new Zend_Form_Element_Select('janela');
    	$janela->setLabel( 'Janela' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty');
    	$janela->addMultiOptions(array(
    			'_self' 	=> 'Mesma Janela',
    			'_blank' 	=> 'Nova Janela'));
    	$this->addElement($janela);

    	$ordem = new Zend_Form_Element_Select('ordem');
    	$ordem->setLabel( 'Nome' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty');
    	$ordem->addMultiOptions(array(
    			1  		=> 'Posição 1',
    			2  		=> 'Posição 2',
    			3  		=> 'Posição 3',
    			4  		=> 'Posição 4',
    			5  		=> 'Posição 5',
    			6  		=> 'Posição 6',
    			7  		=> 'Posição 7',
    			8  		=> 'Posição 8',
    			9  		=> 'Posição 9'));    	
    	$this->addElement($ordem);

    	$datainicio = new Zend_Form_Element_Text('datainicio');
    	$datainicio->setLabel( 'Data Inicio' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'span2 datepicker');
    	$this->addElement($datainicio);

    	$datafim = new Zend_Form_Element_Text('datafim');
    	$datafim->setLabel( 'Data Fim' )
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('StringTrim')
    	->addValidator('NotEmpty')
    	->setAttrib('class', 'span2 datepicker');
    	$this->addElement($datafim);
    	
    	$arquivo = new Zend_Form_Element_File('arquivo');
    	$arquivo->setLabel('Arquivo')
    	->addValidator('Size', false, 1024000)
    	->addValidator('Extension', false, 'jpg,jpeg,png,gif')
    	->setDescription('Somente imagens em jpg, jpeg, png ou gif com tamanho de 940x270.');
    	$this->addElement($arquivo);
    	
    	$destino = new Zend_Form_Element_Text('destino');
    	$destino->setLabel( 'Destino' )
    	->addFilter('StringTrim')
    	->setAttrib('class', 'span6');
    	$this->addElement($destino);   

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

