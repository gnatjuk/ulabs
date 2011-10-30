<?php

/**
 * Description of CommentService
 *
 * @author Jaroslav Gnatjuk
 */

class Service_CommentService extends Service_BaseService {

    /**
     * Comment Zend Table
     * @var CommentTable
     */
    protected $commentTable;

    public function __construct() {
        $this->chapterTable = new Model_CommentTable();
    }
    
    public function getCommentListByPostId($id){
        $where = $this->chapterTable->getAdapter()->quoteInto('post_id = ?', $id);
        return $this->chapterTable->fetchAll($where)->toArray();
    }

}

?>
