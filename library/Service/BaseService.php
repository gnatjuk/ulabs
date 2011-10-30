<?php

/**
 * Description of BaseService
 *
 * @author Jaroslav Gnatjuk
 */
abstract class Service_BaseService {

    private $db;

    public function getDb() {
        $config = Zend_Registry::getInstance()->get('config');
        $this->db = Zend_Db::factory($config->db);
        $this->db->query('SET NAMES utf8');
        return $this->db;
    }

}

?>
