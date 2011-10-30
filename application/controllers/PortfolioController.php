<?php

class PortfolioController extends Controller_BaseController {

    /**
     * accessing our session variable
     * @var type LabService
     */
    protected $labService;

    /**
     * accessing our session variable
     * @var type ProjectService
     */
    protected $projectService;

    public function init() {
        $this->labService = new Service_LabService();
        $this->projectService = new Service_ProjectService();
        $this->view->uri = self::getCurrentUri();
        $this->view->lang = self::getCurrentLang();
        $this->view->constants = self::getPageConstants();
    }

    public function indexAction() {
        $labs = $this->labService->getLabList();
        foreach ($labs as &$lab) { 
            $lab['projects'] = $this->projectService->getProjectListByLabId($lab['id']);
            if (!empty($lab['projects'])) {               
                $lab['work_types'] = $this->projectService->getWorkTypeListByLabId($lab['id']);
            }
        }
        $this->view->labs = $labs;
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['portfolio_title_' . $this->view->lang][0]
              );
    }
    
    public function complexworksAction() {
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['portfolio_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['complex_works_' . $this->view->lang][0]
              );
    }

}

?>
