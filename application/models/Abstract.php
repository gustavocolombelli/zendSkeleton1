<?php

abstract class Application_Model_Abstract {

    protected $_dbTable;


	public function findBy($where, $order = null, $offset = null)
	{
		$select = $this->_dbTable
		->select();

		if (!is_null($where)) {
			foreach ($where as $key => $condition) {
				$select->where($key, $condition);
			}
		}

		if (!is_null($where)) {
			$select->order($order);
		}

		if (!is_null($offset)) {
			$select->limit($offset);
		}


		//echo $select; die;

		return $select->query()->fetch();
	}


    public function find($id) {
        return $this->_dbTable->find($id)->current()->toArray();
    }

    public function save(array $data) {
        if (isset($data['id'])) {
        	unset($data['id']);
            return $this->_update($data);
        } else {
            return $this->_insert($data);
        }
    }

    public function delete($string) {
        return $this->_dbTable->delete($string);
    }

    public function fetchAll($conditions=null, $order=null, $limit=null) {
        $select = $this->_dbTable->select();

        if (!is_null($conditions)) {
            foreach ($conditions as $key => $condition) {
                $select->where($key, $condition);
            }
        }

        if (!is_null($order)) {
        	$select->order($order);
        }

        if(!is_null($limit)) {
            $select->limit($limit);
        }

        //echo $select; die;
        return $select->query()->fetchAll();
    }

    public function search(array $params = null) {
        $str = isset($params['str']) ? $params['str'] : "";
        $page = isset($params['page']) ? (int) $params['page'] : 1;
        $conditions = isset($params['conditions']) ? $params['conditions'] : null;
        $order = isset($params['order']) ? $params['order'] : null;

        $perPage = isset($params['perpage'])
                    ? (int) $params['perpage'] : Zend_Registry::get('config')->paginator->totalItemPerPage;
        $limit = ( $page - 1 ) * $perPage;
        $where = null;
        $select = $this->_dbTable->select();

        if (!empty($str)) {
            $select->where($filtro . " like '%" . $str . "%'" );
        }

        if (is_array($conditions)) {
            foreach ($conditions as $key => $condition) {
                $select->where($key, $condition);
            }
        }

        if (is_array($order)) {
        	foreach ($order as $item) {
        		$select->order($item);
        	}
        }

        if( !is_null($limit) || $limit != 0 )
            $select->limit( $perPage, $limit );
        //echo $select; die;

        $paginator = Zend_Paginator::factory( $select );
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($perPage);

        return $paginator;
    }

    public function fetchPairs( $conditions = null )
    {
        $select = $this->_dbTable->select();

        if (is_array($conditions)) {
            foreach ($conditions as $key => $condition) {
                $select->where($key, $condition);
            }
        }

        return $this->_dbTable->getDefaultAdapter()->fetchPairs( $select );
    }

    abstract public function _insert(array $data);

    abstract public function _update(array $data);
}
