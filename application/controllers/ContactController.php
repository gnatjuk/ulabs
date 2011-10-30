<?php

class ContactController extends Controller_BaseController {

    public function indexAction() {
        $this->view->lang = self::getCurrentLang();
        $this->view->constants = self::getPageConstants();
        $this->view->uri = self::getCurrentUri();
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['contact_title_' . $this->view->lang][0]
              );
    }

}

?>