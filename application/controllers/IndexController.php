<?php

class IndexController extends Controller_BaseController {

    /**
     * accessing our session variable
     * @var type LabService
     */
    protected $labService;
    
    public function init(){
        $this->labService = new Service_LabService();
        $this->view->uri = self::getCurrentUri();
    }

    public function indexAction() {
        $this->view->lang = self::getCurrentLang();
        $this->view->constants = self::getPageConstants();  
        
        $labList = $this->labService->getLabList();
        foreach ($labList as &$lab) {
            $taskList = array();
            //echo 'TITLE:' . $lab['title_' . $lang] . '<br/>';
            $lab['tasks'] = $this->labService->getTaskListByLabId($lab['id']);
        }
        $this->view->labs = $labList;
        
        $this->view->headTitle($this->view->constants['page_title_' . $this->view->lang][0]);
    }

}

