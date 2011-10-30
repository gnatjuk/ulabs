<?php

/**
 * Description of LabService
 *
 * @author Jaroslav Gnatjuk
 */
require_once '/../models/LabTable.php';
require_once 'BaseService.php';
require_once 'TaskService.php';
require_once 'LabTaskService.php';

class LabService extends BaseService {

    /**
     * Lab Zend Table
     * @var LabTable
     */
    protected $labTable;
    protected $taskService;
    protected $labTaskService;

    public function __construct() {
        $this->labTable = new LabTable();
        $this->taskService = new TaskService();
        $this->labTaskService = new LabTaskService();
    }

    public function getLabList() {
        $stmt = self::getDb()->query('SELECT id, name, title_ua, title_en FROM lab');
        return $stmt->fetchAll();
    }

    public function getLabDescriptionByName($name) {
        $stmt = self::getDb()->query("SELECT id, name, text_ua, text_en FROM lab WHERE LOWER(name) = '$name'");
        return $stmt->fetchAll();
    }
    
    public function getTaskListByLabId($id) {
        $taskList = array();
        $tasks = $this->labTaskService->getTasksByLabId($id);
        
        foreach ($tasks as $task){
            $taskList[] = $this->taskService->getTaskById($task['task_id']);
        }
        return $taskList;
    }

}

?>
