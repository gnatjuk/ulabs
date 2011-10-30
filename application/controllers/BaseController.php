<?php

class Controller_BaseController extends Zend_Controller_Action {

    protected function getCurrentLang() {
        return $this->_getParam('lang');
    }

    protected function getPageConstants() {
        $controller = $this->_request->getControllerName();
        $this->pageService = new Service_PageService();
        return $this->pageService->getPageConstantsByPageController($controller);
    }
    
    protected function getCurrentUri(){
        $uri = $this->_request->getPathInfo();
        $uriParams = explode('/', $uri);
        if($uriParams[1] == 'en' || $uriParams[1] == 'ua'){
            unset($uriParams[0], $uriParams[1]);
        }else{
            unset($uriParams[0]);
        }
        return implode('/', $uriParams);
    }

}

?>
