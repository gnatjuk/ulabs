<?php

require_once '/../models/AuthorTable.php';
require_once '/../models/AuthorPostTable.php';
require_once 'BaseService.php';

class AuthorService extends BaseService {

    /**
     * Author Zend Table
     * @var AuthorTable
     */
    protected $authorTable;

    /**
     * AuthorPost Zend Table
     * @var AuthorPostTable
     */
    protected $authorPostTable;

    public function __construct() {
        $this->authorTable = new AuthorTable();
        $this->authorPostTable = new AuthorPostTable();
    }

    public function getAuthorById($id) {
        $where = $this->authorTable->getAdapter()->quoteInto('id = ?', $id);
        return $this->authorTable->fetchAll($where)->current()->toArray();
    }

    public function getAuthorIdListByPostId($id) {
        $where = $this->authorPostTable->getAdapter()->quoteInto('post_id = ?', $id);
        return $this->authorPostTable->fetchAll($where)->toArray();
    }

}

?>
