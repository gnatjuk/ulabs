<?php

class Service_GaleryService extends Service_BaseService {

    /**
     * Galery Zend Table
     * @var GaleryTable
     */
    protected $galeryTable;

    public function __construct() {
        $this->galeryTable = new Model_GaleryTable();
    }

    
    public function getAllGaleries() {
        return $this->galeryTable->fetchAll()->toArray();
    }
    
    public function getGaleryImageListByPageConstantId($id) {
        $where = $this->galeryTable->getAdapter()->quoteInto('page_constant_id = ?', $id);
        return $this->galeryTable->fetchAll($where)->current()->toArray();
    }

}

?>
