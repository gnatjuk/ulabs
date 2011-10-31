<?php

/**
 * Description of LabService
 *
 * @author Jaroslav Gnatjuk
 */

class Service_LabService extends Service_BaseService {

    /**
     * Lab Zend Table
     * @var LabTable
     */
    protected $labTable;
    protected $taskService;
    protected $labTaskService;

    public function __construct() {
        $this->labTable = new Model_LabTable();
        $this->taskService = new Service_TaskService();
        $this->labTaskService = new Service_LabTaskService();
    }

    public function getLabList() {
        $stmt = self::getDb()->query('SELECT id, name, title_ua, title_en FROM lab');
        return $stmt->fetchAll();
    }

    public function getLabDescriptionByName($name) {
        $stmt = self::getDb()->query("SELECT id, name, title_ua, title_en, text_ua, text_en FROM lab WHERE LOWER(name) = '$name'");
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
