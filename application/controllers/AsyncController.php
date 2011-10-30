<?php

class AsyncController extends Controller_BaseController {

    /**
     * accessing our session variable
     * @var type ProjectService
     */
    protected $projectService;

    public function init() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $this->projectService = new Service_ProjectService();
    }

    public function projectAction(){
        $id = $this->getRequest()->getParam('id');
        $project = $this->projectService->getProjectById($id);
        $project['team'] = $this->projectService->getAuthorAndRoleListByProjectId($id);
        echo Zend_Json_Encoder::encode($project);
    }
    
    public function sendmailAction(){
        $name = $this->getRequest()->getParam('name');
        $message = $this->getRequest()->getParam('message');
        $company = $this->getRequest()->getParam('company');
        $email = $this->getRequest()->getParam('email');
        $phone = $this->getRequest()->getParam('phone');
        
        $bodyText = "Імя: " . $name . "\nКомпанія: " . $company . 
                    "\nE-mail: " . $email . "\nТелефон: " . $phone .
                    "\nТекст повідомлення: " . $message;
        
        mail("sl.gnatuk.1989@gmail.com","ulabs.com.ua",$bodyText);
    }
}

?>
