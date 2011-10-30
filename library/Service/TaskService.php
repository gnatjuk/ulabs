<?php

/**
 * Description of TaskService
 *
 * @author Jaroslav Gnatjuk
 */

class Service_TaskService extends Service_BaseService {

    /**
     * Task Zend Table
     * @var TaskTable
     */
    protected $taskTable;

    public function __construct() {
        $this->taskTable = new Model_TaskTable();
    }

    public function getTaskById($id) {
        return $this->taskTable->find($id)->current()->toArray();
    }

}

?>
