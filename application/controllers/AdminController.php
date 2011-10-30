<?php

class AdminController extends Controller_BaseController{
    
    public function init(){
        $this->view->uri = self::getCurrentUri();
        $this->view->constants = self::getPageConstants();
    }
    
    public function indexAction(){
        echo "<h1>ТУТ БУДЕ АДМІНКА ;)</h1>";
    }
}

?>
