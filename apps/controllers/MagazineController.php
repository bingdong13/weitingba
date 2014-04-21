<?php

use \Phalcon\Exception as PhException;

class MagazineController extends ControllerBase
{
    public function initialize(){
        parent::initialize();

        $this->style->addCss('/css/golden.css');
        $this->script->addJs('/js/shared.js');
        $this->view->setVar('isLogin', $this->userIdentity->isLogin());
    }

    public function indexAction() {
        $this->tag->prependTitle(Lang::tip('TMagazine'));

        $cid = (int)$this->dispatcher->getParam('cid');

        $categorys = Category::getList(Category::CHANNEL_MAGAZINE);

        if( $cid ){
            $category = $categorys[$cid];
            $this->view->setVar('category', $category);
            $this->view->setVar('keywords', $category['keywords']);
            $this->view->setVar('descript', $category['description']);
        }else{
            $magazine = $this->config->channel->magazine;
            $magazine['numbers'] = Magazine::count();

            $this->view->setVar('category', $magazine);
            $this->view->setVar('keywords', $magazine->keywords);
            $this->view->setVar('descript', $magazine->description);
        }

        $this->view->setVar('curr_category', $cid);
        $this->view->setVar('categorys', $categorys);
    }

    public function infoAction(){
        $nid = (int)$this->dispatcher->getParam('nid');
        if( !$nid ){
            $this->forward('error/show404');
            return false;
        }

        $zine = Magazine::get($nid);
        if( empty($zine) ){
            $this->forward('error/show404');
            return false;
        }
        
        $this->tag->prependTitle( $zine->title );
        $this->view->setVar('keywords', $zine->keywords);
        $this->view->setVar('descript', $zine->description);

        $magazine = new Magazine();
        $zine->access_times += $magazine->increment($nid);

        $categorys = Category::getList( Category::CHANNEL_MAGAZINE );
        $zine->category_name = $categorys[$zine->category_id]['title'];
            
        $this->view->setVar('zine', $zine);
        $this->view->setVar('preZine', Magazine::getPrevious($nid));
        $this->view->setVar('nextZine', Magazine::getNext($nid));
        $this->view->setVar('category', $categorys[$zine->category_id]);
    }
    
    public function loadListAction(){
        $this->view->disable();
        
        if( !$this->request->isAjax() ){
            exit('');
        }

        $number = 15;
        $offset = $this->request->getPost('offset', 'int', 0);
        $category = $this->request->getPost('cid', 'int', 0);
        
        $magazine = new Magazine();
        $records = $magazine->getList($number, $offset, $category);

        $this->view->setVar('records', $records);
        $this->view->partial('magazine/magazine_partial');
        
        return false;
    }

    public function deleteAction(){
        
        $nid = $this->request->getPost('nid', 'int', 0);
        
        try {
            
            $this->checkAjax();
            
            if( !$nid ){
                throw new PhException('EParamError');
            }

            Magazine::del($nid);

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
        
        $record = Magazine::findFirst($params[0]);
        
        $this->view->setVar('title', String::msubstr($record->title, 0, 30));
        $this->view->setVar('oldCategory', $record->category_id);
        $this->view->setVar('categorys', Category::getList( Category::CHANNEL_MAGAZINE ));
        $this->view->setVar('action', $this->url->get('magazine/updateCategory/' . $record->id));
        
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

            $magazine = new Magazine();
            $magazine->updateCategory(intval($params[0]), $cid);

            echo Lang::jsonSuccess('SUpdate');
            
        } catch (PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
}