<?php

/**
 * Description of ChapterService
 *
 * @author Jaroslav Gnatjuk
 */

class Service_ChapterService extends Service_BaseService {

    /**
     * Chapter Zend Table
     * @var ChapterTable
     */
    protected $chapterTable;

    /**
     * ChapterPost Zend Table
     * @var ChapterPostTable
     */
    protected $chapterPostTable;

    public function __construct() {
        $this->chapterTable = new Model_ChapterTable();
        $this->chapterPostTable = new Model_ChapterPostTable();
    }

    public function getFullChapterList() {
        return $this->chapterTable->fetchAll()->toArray();
    }

    public function getChapterListByType($type) {
        $where = $this->chapterTable->getAdapter()->quoteInto('type = ?', $type);
        return $this->chapterTable->fetchAll($where)->toArray();
    }

    public function getPostCountByChapterId($id) {
        $sql = "SELECT COUNT(id) FROM chapter_post WHERE chapter_id = '$id'";
        $stmt = self::getDb()->query($sql);
        $rs = $stmt->fetchAll();
        return $rs[0]['COUNT(id)'];
    }
    
    public function getChapterListByPostId($id){
        $where = $this->chapterPostTable->getAdapter()->quoteInto('post_id = ?', $id);
        return $this->chapterPostTable->fetchAll($where)->toArray();
    }
    
    public function getChapterById($id){
        $where = $this->chapterTable->getAdapter()->quoteInto('id = ?', $id);
        return $this->chapterTable->fetchAll($where)->current()->toArray();
    }
    
        
    public function getChapterByUri($uri){
        $where = $this->chapterTable->getAdapter()->quoteInto('uri = ?', $uri);
        return $this->chapterTable->fetchAll($where)->current()->toArray();
    }

        
    public function getPostIdListByChapterId($id){
        $where = $this->chapterPostTable->getAdapter()->quoteInto('chapter_id = ?', $id);
        return $this->chapterPostTable->fetchAll($where)->toArray();
    }
}

?>
