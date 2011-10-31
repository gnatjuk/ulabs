<?php

class AboutController extends Controller_BaseController {

    /**
     * accessing our session variable
     * @var type GaleryService
     */
    protected $galeryService;
    
    /**
    * accessing our session variable
    * @var type GaleryService
    */
    protected $labService;
    
    public function init(){
        $this->galeryService = new Service_GaleryService();
        $this->labService = new Service_LabService();
        $this->view->uri = self::getCurrentUri();
    }
    
    public function indexAction() {
        $this->view->lang = self::getCurrentLang();
        $this->view->constants = self::getPageConstants();
        $this->view->headTitle(
                                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                                $this->view->constants['why_u_' . $this->view->lang][0]
                              );
        $this->view->galeries = $this->galeryService->getAllGaleries();
        $this->view->labs = $this->labService->getLabList();
    }
}

?>
