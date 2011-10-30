<?php

/**
 * Description of CommentService
 *
 * @author Jaroslav Gnatjuk
 */
require_once '/../models/CommentTable.php';
require_once 'BaseService.php';

class CommentService extends BaseService {

    /**
     * Comment Zend Table
     * @var CommentTable
     */
    protected $commentTable;

    public function __construct() {
        $this->chapterTable = new CommentTable();
    }
    
    public function getCommentListByPostId($id){
        $where = $this->chapterTable->getAdapter()->quoteInto('post_id = ?', $id);
        return $this->chapterTable->fetchAll($where)->toArray();
    }

}

?>
