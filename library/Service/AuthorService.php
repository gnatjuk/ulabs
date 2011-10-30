<?php

class Service_AuthorService extends Service_BaseService {

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
        $this->authorTable = new Model_AuthorTable();
        $this->authorPostTable = new Model_AuthorPostTable();
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
