<?php

/**
 * Description of TaskService
 *
 * @author Jaroslav Gnatjuk
 */

class Service_LabTaskService extends Service_BaseService {

    /**
     * Lab Task Zend Table
     * @var LabTaskTable
     */
    protected $labTaskTable;

    public function __construct() {
        $this->labTaskTable = new Model_LabTaskTable();
    }

    public function getTasksByLabId($id) {
        $where = $this->labTaskTable->getAdapter()->quoteInto('lab_id = ?', $id);
        return $this->labTaskTable->fetchAll($where)->toArray();
    }

}
?>

