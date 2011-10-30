<?php

/**
 * Description of PageService
 *
 * @author Jaroslav Gnatjuk
 */
require_once '/../models/PageConstantsTable.php';
require_once 'BaseService.php';

class PageService extends BaseService {

    /**
     * PageConstants Zend Table
     * @var PageConstantsTable
     */
    protected $pageConstantsTable;

    public function __construct() {
        $this->pageConstantsTable = new PageConstantsTable();
    }

    public function getPageConstantsByPageController($pageController) {
        $where = $this->pageConstantsTable->getAdapter()
                ->quoteInto("page = ? OR page = 'all'", $pageController);
        $constArray = $this->pageConstantsTable->fetchAll($where)->toArray();

        $pageConstants = array();
        foreach ($constArray as $const) {
            $pageConstants[$const['name'] . '_id'][] = $const['id'];
            $pageConstants[$const['name'] . '_ua'][] = $const['constant_ua'];
            $pageConstants[$const['name'] . '_en'][] = $const['constant_en'];
        }

        return $pageConstants;
    }

}

?>
