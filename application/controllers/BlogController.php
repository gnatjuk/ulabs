<?php

class BlogController extends Controller_BaseController {

    /**
     * accessing our session variable
     * @var type PostService
     */
    protected $postService;

    /**
     * accessing our session variable
     * @var type ChapterService
     */
    protected $chapterService;

    /**
     * accessing our session variable
     * @var type CommentService
     */
    protected $commentService;

    /**
     * accessing our session variable
     * @var type DateService
     */
    protected $dateService;
    
    /**
     * accessing our session variable
     * @var type SearchService
     */
    protected $searchService;

    public function init() {
        $this->view->lang = self::getCurrentLang();
        $this->view->constants = self::getPageConstants();
        $this->postService = new Service_PostService();
        $this->chapterService = new Service_ChapterService();
        $this->commentService = new Service_CommentService();
        $this->dateService = new Service_DateService();
        $this->searchService = new Service_SearchService();
        $this->view->generalChapters = $this->getGeneralChapters();
        $this->view->labChapters = $this->getLabChapters();
        $this->view->uri = self::getCurrentUri();
    }

    public function indexAction() {
        $posts = $this->postService->getPostList();
        $this->view->posts = $this->trasformPosts($posts);
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['blog_title_' . $this->view->lang][0]
              );
    }

    public function postAction() {
        $uri = $this->_getParam('post');
        $post = $this->postService->getPostByUri($uri);
        $post['date'] = $this->dateService->transrormDate($post['date'], $this->view->lang);
        $post['authors'] = $this->postService->getAuthorListByPostId($post['id']);
        $post['labels'] = $this->postService->getLabelListByPostId($post['id']);
        $this->view->post = $post;
        $this->view->comments = $this->commentService->getCommentListByPostId($post['id']);
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['blog_title_' . $this->view->lang][0] . ' | ' .
                $post['title_' . $this->view->lang]
              );
    }

    
    public function chapterAction() {
        $uri = $this->_getParam('chapter');
        $posts = $this->postService->getPostListByChapterUri($uri);
        $this->view->posts = $this->trasformPosts($posts);
        $chapter = $this->chapterService->getChapterByUri($uri);
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['blog_title_' . $this->view->lang][0] . ' | ' .
                $chapter['name_' . $this->view->lang]
              );
    }
    
    public function searchAction() {
        $searchQuery = $this->_getParam('search_query');
        $posts = $this->searchService->getPostListBySearchQuery($searchQuery);
        $this->view->posts = $this->trasformPosts($posts);  
        $this->view->searchQuery = $searchQuery;
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['blog_title_' . $this->view->lang][0]
             );
    }
    
    private function getGeneralChapters() {
        $generalChapters = $this->chapterService->getChapterListByType('general');
        foreach ($generalChapters as &$chapter) {
            $chapter['post_count'] = $this->chapterService->getPostCountByChapterId($chapter['id']);
        }
        return $generalChapters;
    }

    private function getLabChapters() {
        $labels = $this->chapterService->getChapterListByType('label');
        foreach ($labels as &$label) {
            $label['post_count'] = $this->chapterService->getPostCountByChapterId($label['id']);
        }
        return $labels; 
    }
    
    private function trasformPosts($posts){
        
        foreach ($posts as &$post) {
            $post['date'] = $this->dateService->transrormDate($post['date'], $this->view->lang);
            $post['comment_count'] = count($this->commentService->getCommentListByPostId($post['id']));
            $post['authors'] = $this->postService->getAuthorListByPostId($post['id']);
            $post['labels'] = $this->postService->getLabelListByPostId($post['id']);
        }
        
        return $posts;
    }

}

?>