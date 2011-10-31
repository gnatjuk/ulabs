<?php

class LabController extends Controller_BaseController {
    /**
     * accessing our session variable
     * @var type LabService
     */
    protected $labService;
    
    /**
    * accessing our session variable
    * @var type PostService
    */
    protected $postService;
    
    /**
     * accessing our session variable
     * @var type ProjectService
     */
    protected $projectService;
    
    public function init(){
        $this->view->uri = self::getCurrentUri();
        $this->labService = new Service_LabService();
        $this->postService = new Service_PostService();
        $this->projectService = new Service_ProjectService();
        $this->view->lang = self::getCurrentLang();
        $this->view->constants = self::getPageConstants();
    }


    public function indexAction() {
        $lab = $this->_getParam('lab');
        $labInfo = $this->labService->getLabDescriptionByName($lab);
        $labInfo['tasks'] = $this->labService->getTaskListByLabId($labInfo[0]['id']);
        $labInfo['projects'] = $this->projectService->getProjectListByLabId($labInfo[0]['id']);
        foreach ($labInfo['projects'] as &$labProject) {
            $post = $this->postService->getPostById($labProject['post_id']);
            $labProject['post_uri'] = $post['uri'];
        }
        $this->view->labInfo = $labInfo;
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->labInfo[0]['name']
              );
    }

}

?>
