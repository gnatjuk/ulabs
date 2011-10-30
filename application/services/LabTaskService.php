<?php

/**
 * Description of TaskService
 *
 * @author Jaroslav Gnatjuk
 */
require_once '/../models/LabTaskTable.php';
require_once 'BaseService.php';

class LabTaskService extends BaseService {

    /**
     * Lab Task Zend Table
     * @var LabTaskTable
     */
    protected $labTaskTable;

    public function __construct() {
        $this->labTaskTable = new LabTaskTable();
    }

    public function getTasksByLabId($id) {
        $where = $this->labTaskTable->getAdapter()->quoteInto('lab_id = ?', $id);
        return $this->labTaskTable->fetchAll($where)->toArray();
    }

}
?>

