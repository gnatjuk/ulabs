<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected $router;

    protected function _initView() {
        // Init view
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->addHelperPath('App/View/Helper', 'App_View_Helper');
        // Add view into ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
    }

    protected function _initConfig() {
        $this->config = new Zend_Config_Ini('../application/config.ini', 'general');
        $registry = Zend_Registry::getInstance();
        $registry->set('config', $this->config);
    }

    protected function _initDbAdapter() {
        $db = Zend_Db::factory($this->config->db);
        $db->query('SET NAMES utf8');
        Zend_Db_Table::setDefaultAdapter($db);
    }
	
    protected function _initAutoload()
    {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('Service_');
        $loader->registerNamespace('Controller_');
        $loader->registerNamespace('Model_');
    }

    protected function _initRouters() {
        $frontController = Zend_Controller_Front::getInstance();
        $this->router = $frontController->getRouter();

        $this->initDefaultRoute();
        $this->initStaticPageRoute();
        $this->initBlogPostRoute();
        $this->initBlogChaptersRoute();
        $this->initBlogSearchRoute();
        $this->initLabRoute();
        $this->initAsyncJavaScriptResponseRoutes();
        $this->initComplexWorksRoute();
        $this->initAdminRoutes();
    }

    private function initDefaultRoute() {
        $this->router->addRoute('default', new Zend_Controller_Router_Route(':lang/:controller/:action/*',
                        array('lang' => 'ua', 'controller' => 'index', 'action' => 'index')
                )
        );
    }

    private function initStaticPageRoute() {
        $this->router->addRoute('staticPageRoute', new Zend_Controller_Router_Route('/:controller',
                        array('lang' => 'ua', 'action' => 'index'), array('controller' => '(?!en$).+'))
        );
    }

    private function initBlogPostRoute() {
        $this->router->addRoute('blogPostWithoutLangRoute', new Zend_Controller_Router_Route('/blog/post/:post',
                        array('lang' => 'ua', 'controller' => 'blog', 'action' => 'post', 'post' => ':post')
                )
        );

        $this->router->addRoute('blogPostWithLangRoute', new Zend_Controller_Router_Route(':lang/blog/post/:post',
                        array('lang' => 'ua', 'controller' => 'blog', 'action' => 'post', 'post' => ':post')
                )
        );
    }
    
    private function initBlogChaptersRoute() {
        $this->router->addRoute('blogChapterWithoutLangRoute', new Zend_Controller_Router_Route('/blog/chapter/:chapter',
                        array('lang' => 'ua', 'controller' => 'blog', 'action' => 'chapter', 'chapter' => ':chapter')
                )
        );

        $this->router->addRoute('blogChapterWithLangRoute', new Zend_Controller_Router_Route(':lang/blog/chapter/:chapter',
                        array('lang' => 'ua', 'controller' => 'blog', 'action' => 'chapter', 'chapter' => ':chapter')
                )
        );
    }
    
    private function initBlogSearchRoute() {
        $this->router->addRoute('blogSearchWithoutLangRoute', new Zend_Controller_Router_Route('/blog/search/',
                        array('lang' => 'ua', 'controller' => 'blog', 'action' => 'search')
                )
        );

        $this->router->addRoute('blogSearchWithLangRoute', new Zend_Controller_Router_Route(':lang/blog/search/',
                        array('lang' => 'ua', 'controller' => 'blog', 'action' => 'search')
                )
        );
    }
    
    private function initLabRoute() {
        $this->router->addRoute('labPageWithoutLangRoute', new Zend_Controller_Router_Route('/lab/:lab',
                        array('lang' => 'ua', 'controller' => 'lab', 'action' => 'index')
                )
        );

        $this->router->addRoute('labPageWithLangRoute', new Zend_Controller_Router_Route(':lang/lab/:lab',
                        array('lang' => 'ua', 'controller' => 'lab', 'action' => 'index')
                )
        );
    }
        
    private function initComplexWorksRoute() {
        $this->router->addRoute('complexWorksWithoutLangRoute', new Zend_Controller_Router_Route('/portfolio/complex-works/',
                        array('lang' => 'ua', 'controller' => 'portfolio', 'action' => 'complexworks')
                )
        );

        $this->router->addRoute('complexWorksWithLangRoute', new Zend_Controller_Router_Route(':lang/portfolio/complex-works/',
                        array('lang' => 'ua', 'controller' => 'portfolio', 'action' => 'complexworks')
                )
        );
        
        $this->router->addRoute('complexWorksWithFilterWithoutLangRoute', new Zend_Controller_Router_Route('/portfolio/complex-works/:filter',
                        array('lang' => 'ua', 'controller' => 'portfolio', 'action' => 'complexworksfilter')
                )
        );

        $this->router->addRoute('complexWorksWithFilterWithLangRoute', new Zend_Controller_Router_Route(':lang/portfolio/complex-works/:filter',
                        array('lang' => 'ua', 'controller' => 'portfolio', 'action' => 'complexworksfilter')
                )
        );
    }
    
        
    private function initAsyncJavaScriptResponseRoutes() {
        $this->router->addRoute('asyncProjectRoute', new Zend_Controller_Router_Route('/async/project/:id',
                        array('controller' => 'async', 'action' => 'project')
                )
        );
        $this->router->addRoute('asyncSendMailRoute', new Zend_Controller_Router_Route('/async/sendmail/',
                        array('controller' => 'async', 'action' => 'sendmail')
                )
        );
    }
    
            
    private function initAdminRoutes() {
        $this->router->addRoute('adminPageWithoutLangRoute', new Zend_Controller_Router_Route('/admin/',
                        array('lang' => 'ua', 'controller' => 'admin', 'action' => 'index')
                )
        );

        $this->router->addRoute('adminPageWithLangRoute', new Zend_Controller_Router_Route(':lang/admin/',
                        array('lang' => 'ua', 'controller' => 'admin', 'action' => 'index')
                )
        );
        
        $this->router->addRoute('adminPageLoginRoute', new Zend_Controller_Router_Route('/admin/login/',
                        array('controller' => 'admin', 'action' => 'login')
                )
        );
              
        $this->router->addRoute('adminPageLogoutRoute', new Zend_Controller_Router_Route('/admin/logout/',
                        array('controller' => 'admin', 'action' => 'logout')
                )
        );
        
                      
        $this->router->addRoute('adminPortfolioRoute', new Zend_Controller_Router_Route('/admin/portfolio/',
                        array('controller' => 'admin', 'action' => 'portfolio')
                )
        );
        
                      
        $this->router->addRoute('adminBlogRoute', new Zend_Controller_Router_Route('/admin/blog/',
                        array('controller' => 'admin', 'action' => 'blog')
                )
        );
        
                      
        $this->router->addRoute('adminLabsRoute', new Zend_Controller_Router_Route('/admin/labs',
                        array('controller' => 'admin', 'action' => 'labs')
                )
        );
        
        
        $this->router->addRoute('adminPagesRoute', new Zend_Controller_Router_Route('/admin/pages',
                        array('controller' => 'admin', 'action' => 'pages')
                )
        );
    }

}