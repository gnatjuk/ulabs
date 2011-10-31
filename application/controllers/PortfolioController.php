<?php

class PortfolioController extends Controller_BaseController {

    /**
     * accessing our session variable
     * @var type LabService
     */
    protected $labService;
    
    /**
    * accessing our session variable
    * @var type DateService
    */
    protected $dateService;
    
    /**
    * accessing our session variable
    * @var type CommentService
    */
    protected $commentService;
    
    /**
    * accessing our session variable
    * @var type PostService
    */
    protected $postService;
    
    /**
     * accessing our session variable
     * @var type ProjectService
     */
    protected $projectService;
    
    /**
     * accessing our session variable
     * @var type ProjectService
     */
    protected $chapterService;

    public function init() {
        $this->labService = new Service_LabService();
        $this->projectService = new Service_ProjectService();
        $this->postService = new Service_PostService();
        $this->dateService = new Service_DateService();
        $this->commentService = new Service_CommentService();
        $this->chapterService = new Service_ChapterService();
        $this->view->uri = self::getCurrentUri();
        $this->view->lang = self::getCurrentLang();
        $this->view->constants = self::getPageConstants();
        $this->view->labChapters = $this->getLabChapters();
    }

    public function indexAction() {
        $labs = $this->labService->getLabList();
        foreach ($labs as &$lab) { 
            $lab['projects'] = $this->projectService->getProjectListByLabId($lab['id']);
            if (!empty($lab['projects'])) {
                foreach ($lab['projects'] as &$labProject) {
                    $post = $this->postService->getPostById($labProject['post_id']);
                    $labProject['post_uri'] = $post['uri'];
                }
                $lab['work_types'] = $this->projectService->getWorkTypeListByLabId($lab['id']);
            }
        }
        $this->view->labs = $labs;
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['portfolio_title_' . $this->view->lang][0]
              );
    }
    
    public function complexworksAction() {
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['portfolio_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['complex_works_' . $this->view->lang][0]
              );
        
        $posts = $this->postService->getPostListByChapterUri('our-projects');
        $this->view->posts = $this->trasformPosts($posts);
    }
    
        
    public function complexworksfilterAction() {
        $filter = $this->_getParam('filter');
        $this->view->headTitle(
                $this->view->constants['page_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['portfolio_title_' . $this->view->lang][0] . ' | ' .
                $this->view->constants['complex_works_' . $this->view->lang][0]
              );
        
        $ourProjectsChapter = $this->chapterService->getChapterByUri('our-projects');
        $filterChapter = $this->chapterService->getChapterByUri($filter);
        $postComplexProjectIdList = $this->chapterService->getPostIdListByChapterId($ourProjectsChapter['id']);
        $filterProjectIdList = $this->chapterService->getPostIdListByChapterId($filterChapter['id']);
        $resultPostIdList = array();
        foreach ($postComplexProjectIdList as $ChPostId) {
            foreach ($filterProjectIdList as $FlPostId) {
                if ($ChPostId['post_id'] === $FlPostId ['post_id']) {
                    $resultPostIdList[] = $FlPostId;
                    break;
                }
            }
        }
        $posts = array();
        foreach ($resultPostIdList as $postId) {
            $posts[] = $this->postService->getPostById($postId['post_id']);
        }
        $this->view->posts = $this->trasformPosts($posts);
    }
    
    
    private function getLabChapters() {
        $ourProjectsChapter = $this->chapterService->getChapterByUri('our-projects');
        $labels = $this->chapterService->getChapterListByType('label');
        foreach ($labels as &$label) {  
            $postComplexProjectIdList = $this->chapterService->getPostIdListByChapterId($ourProjectsChapter['id']);
            $filterProjectIdList = $this->chapterService->getPostIdListByChapterId($label['id']);
            $resultPostIdList = array();
            foreach ($postComplexProjectIdList as $ChPostId) {
                foreach ($filterProjectIdList as $FlPostId) {
                    if ($ChPostId['post_id'] === $FlPostId ['post_id']) {
                        $resultPostIdList[] = $FlPostId;
                        break;
                    }
                }
            }
            $posts = array();
            foreach ($resultPostIdList as $postId) {
                $posts[] = $this->postService->getPostById($postId['post_id']);
            }
            $label['post_count'] = count($posts);
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
