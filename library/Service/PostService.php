<?php

/**
 * Description of PostService
 *
 * @author Jaroslav Gnatjuk
 */

class Service_PostService extends Service_BaseService {

    /**
     * Lab Zend Table
     * @var LabTable
     */
    protected $postTable;

    /**
     * Author Service
     * @var AuthorService
     */
    protected $authorService;

    /**
     * Chapter Service
     * @var ChapterService
     */
    protected $chapterService;
    
    public function __construct() {
        $this->postTable = new Model_PostTable();
        $this->authorService = new Service_AuthorService();
        $this->chapterService = new Service_ChapterService();
    }

    public function getPostList() {
        $sql = "SELECT * FROM posts";
        $stmt = self::getDb()->query($sql);
        return $stmt->fetchAll();
    }

    public function getPostByUri($uri) {
        $where = $this->postTable->getAdapter()->quoteInto('uri = ?', $uri);
        return $this->postTable->fetchAll($where)->current()->toArray();
    }

    
    public function getPostById($id) {
        $where = $this->postTable->getAdapter()->quoteInto('id = ?', $id);
        if ($this->postTable->fetchAll($where)->current() != null) {
            return $this->postTable->fetchAll($where)->current()->toArray();
        } else {
            return $this->postTable->fetchAll($where)->current();
        }
    }
    
    public function getAuthorListByPostId($id) {
        $idList = $this->authorService->getAuthorIdListByPostId($id);
        $authorList = array();
        foreach ($idList as $elem) {
            $authorList[] = $this->authorService->getAuthorById($elem['author_id']);
        }
        return $authorList;
    }

    public function getLabelListByPostId($id) {
        $chapterIdList = $this->chapterService->getChapterListByPostId($id);
        $labelList = array();
        foreach ($chapterIdList as $elem) {
            $labelList[] = $this->chapterService->getChapterById($elem['chapter_id']);
        }
        return $labelList;
    }
    
    public function getPostListByChapterUri($uri){
        $chapter = $this->chapterService->getChapterByUri($uri);
        $postIdList = $this->chapterService->getPostIdListByChapterId($chapter['id']);
        $posts = array();
        foreach ($postIdList as $elem) {
            $posts[] = $this->getPostById($elem['post_id']);
        }
        return $posts;
    }

}

?>
