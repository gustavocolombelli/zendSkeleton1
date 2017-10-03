<?php

abstract class Application_Model_DbTable_Abstract extends Zend_Db_Table_Abstract {

	public function init(){
		if(!empty($this->_DBAdpterName)){
			$this->_setAdapter($this->_DBAdpterName);
		}

	}
}
