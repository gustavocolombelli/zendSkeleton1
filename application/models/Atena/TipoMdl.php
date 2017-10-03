<?php

class Application_Model_Atena_TipoMdl extends Application_Model_Abstract
{
    public function __construct() {
        $this->_dbTable = new Application_Model_Atena_TipoDbt();
    }

    public function _insert(array $data) {
        return $this->_dbTable->insert($data);
    }

    public function _update(array $data) {
        return $this->_dbTable->update($data, array('idtipo = ?' => $data['idtipo']));
    }


}

