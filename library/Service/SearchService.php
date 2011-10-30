<?php

/**
 * Description of PostService
 *
 * @author Jaroslav Gnatjuk
 */

class Service_SearchService extends Service_BaseService {

    /**
     * Lab Zend Table
     * @var LabTable
     */
    protected $postTable;

    /**
     * accessing our session variable
     * @var type PostService
     */
    protected $postService;

    public function __construct() {
        $this->postTable = new Model_PostTable();
        $this->postService = new Service_PostService();
    }

    public function getPostListBySearchQuery($searchQuery) {
        $posts = $this->postService->getPostList();
        $resultPostList = array();
        foreach ($posts as $post) {
            if (strstr($post['title_ua'], $searchQuery) != false ||
                    strstr($post['title_en'], $searchQuery) != false) {
                $resultPostList[] = $post;
            }else if(strstr($post['text_ua'], $searchQuery) != false ||
                    strstr($post['text_en'], $searchQuery) != false){
                $resultPostList[] = $post;
            }
        }
        return $resultPostList;
    }

}

?>
