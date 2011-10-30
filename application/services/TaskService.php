<?php

/**
 * Description of TaskService
 *
 * @author Jaroslav Gnatjuk
 */
require_once '/../models/TaskTable.php';
require_once 'BaseService.php';

class TaskService extends BaseService {

    /**
     * Task Zend Table
     * @var TaskTable
     */
    protected $taskTable;

    public function __construct() {
        $this->taskTable = new TaskTable();
    }

    public function getTaskById($id) {
        return $this->taskTable->find($id)->current()->toArray();
    }

}

?>
