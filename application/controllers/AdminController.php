<?php

class AdminController extends Controller_BaseController {

    /**
     * accessing our session variable
     * @var type Zend_Session_Namespace
     */
    protected $session;

    public function init() {
        $this->view->headTitle('Адміністративна панель | Обєднані бізнес-лабораторії  "U"');
    }

    public function preDispatch() {
        $this->session = new Zend_Session_Namespace('Default');
    }

    public function indexAction() {
        if ($this->getRequest()->isPost()) {
            $admin = new Model_Admin(
                            $this->_getParam('user'),
                            $this->_getParam('pass')
            );
            if (
                    isset($admin->login, $admin->pass) &&
                    !empty($admin->login) &&
                    !empty($admin->pass) &&
                    $admin->login === "admin" &&
                    $admin->pass === "admin"
            ) {
                $this->session->admin = $admin;
            }
        }
        $this->isUserInSession();
    }

    public function loginAction() {
        if (isset($this->session->admin)) {
            $this->_redirect('/admin');
        }
    }

    public function logoutAction() {
        $this->session->admin = null;
        $this->_redirect('/admin/login/');
    }

    public function blogAction() {

    }
    
    public function portfolioAction() {

    }
        
    public function pagesAction() {

    }
        
    public function labsAction() {

    }
    
    private function isUserInSession() {
        if (!isset($this->session->admin)) {
            $this->_redirect('/admin/login/');
        }
    }
    

}

?>
