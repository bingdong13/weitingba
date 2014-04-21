<?php

use \Phalcon\Exception as PhException;

class SharedController extends ControllerBase
{
    public function initialize(){
        parent::initialize();
    }

    public function indexAction() {
        $this->tag->prependTitle(Lang::tip('TShared'));
        
        $this->style->addCss('/css/golden.css');
        $this->script->addJs('/js/shared.js');

        $cid = (int)$this->dispatcher->getParam('cid');

        $categorys = Category::getList(Category::CHANNEL_SHARED);

        if( $cid ){
            $category = $categorys[$cid];
            $this->view->setVar('category', $category);
            $this->view->setVar('keywords', $category['keywords']);
            $this->view->setVar('descript', $category['description']);
        }else{
            $shared = $this->config->channel->shared;
            $shared['numbers'] = Shared::count();

            $this->view->setVar('category', $shared);
            $this->view->setVar('keywords', $shared->keywords);
            $this->view->setVar('descript', $shared->description);
        }

        $this->view->setVar('curr_category', $cid);
        $this->view->setVar('categorys', $categorys);
        $this->view->setVar('isLogin', $this->userIdentity->isLogin());
    }
    
    public function loadListAction(){
        $this->view->disable();
        
        if( !$this->request->isAjax() ){
            exit('');
        }

        $number = 15;
        $offset = $this->request->getPost('offset', 'int', 0);
        $category = $this->request->getPost('cid', 'int', 0);
        
        $shareds = Shared::getList($number, $offset, $category);
        if($shareds === false){
           exit('');
        }

        $this->view->setVar('shareds', $shareds);
        $this->view->setVar('isLogin', $this->userIdentity->isLogin());

        $this->view->partial('shared/shared_partial');
        
        return false;
    }

    public function addAction() {
        
        $content = $this->request->getPost('content');
        $categoryId = (int)$this->request->getPost('category');
        $istop = (int)$this->request->getPost('istop');
        
        try {
            
            $this->checkAjaxForm();

            if(!$content){
                throw new PhException('EShareIsEmpty');
            }

            if(!$categoryId){
                throw new PhException('ECategoryIsEmpty');
            }

            $shared = new Shared();
            $shared->content = $content;
            $shared->category_id = $categoryId;
            $shared->is_top = $istop;
            if ( $shared->create() === false ) {
                throw new PhException('ESystemError');
            }
            
            echo Lang::jsonSuccess('SPublish');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function deleteAction(){
        
        $sid = $this->request->getPost('sid', 'int', 0);
        
        try {
            
            $this->checkAjax();
            
            if( !$sid ){
                throw new PhException('EParamError');
            }

            Shared::del($sid);

            echo Lang::jsonSuccess('SDelete');
            
        } catch (PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
    
    public function changeCategoryAction(){
        $this->view->disable();
        
        $params = $this->dispatcher->getParams();
        
        if( !isset($params[0]) || !intval($params[0])){
            echo Lang::tip('EParamError');
            exit();
        }
        
        $record = Shared::findFirst($params[0]);
        
        $this->view->setVar('title', String::msubstr($record->content, 0, 30) );
        $this->view->setVar('oldCategory', $record->category_id);
        $this->view->setVar('categorys', Category::getList( Category::CHANNEL_SHARED ));
        $this->view->setVar('action', $this->url->get('shared/updateCategory/' . $record->id));
        
        $this->view->partial('common/changeCategory');
    }
    
    public function updateCategoryAction(){
        $cid = $this->request->getPost('cid', 'int', 0);
        
        $params = $this->dispatcher->getParams();
        if( !isset($params[0]) || !intval($params[0])){
            echo Lang::jsonError( 'EParamError' );
            exit();
        }
        
        try {
            
            $this->checkAjax();
            
            if( !$cid ){
                throw new PhException('EParamError');
            }

            $shared = new Shared();
            $shared->updateCategory(intval($params[0]), $cid);

            echo Lang::jsonSuccess('SUpdate');
            
        } catch (PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
}