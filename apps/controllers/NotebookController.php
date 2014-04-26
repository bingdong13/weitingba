<?php

use \Phalcon\Exception as PhException;

class NotebookController extends ControllerBase
{
    public function initialize(){
        parent::initialize();

        $this->style->addCss('/css/golden.css');
        $this->script->addJs('/js/shared.js');
        
        $this->view->setVar('isAdmin', $this->userIdentity->isAdmin());
    }

    public function indexAction() {
        $this->tag->prependTitle(Lang::tip('TNotebook'));

        $cid = (int)$this->dispatcher->getParam('cid');

        $categorys = Category::getList(Category::CHANNEL_NOTEBOOK);

        if( $cid ){
            $category = $categorys[$cid];
            $this->view->setVar('category', $category);
            $this->view->setVar('keywords', $category['keywords']);
            $this->view->setVar('descript', $category['description']);
        }else{
            $notebook = $this->config->channel->notebook;
            $notebook['numbers'] = NoteBook::count();

            $this->view->setVar('category', $notebook);
            $this->view->setVar('keywords', $notebook->keywords);
            $this->view->setVar('descript', $notebook->description);
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

        $note = NoteBook::get($nid);
        if( empty($note) ){
            $this->forward('error/show404');
            return false;
        }
        
        $this->tag->prependTitle( $note->title );
        $this->view->setVar('keywords', $note->keywords);
        $this->view->setVar('descript', $note->description);
        
        $notebook = new NoteBook();
        $note->access_times += $notebook->increment($nid);

        $categorys = Category::getList( Category::CHANNEL_NOTEBOOK );
        $note->category_name = $categorys[$note->category_id]['title'];

        $this->view->setVar('note', $note);
        $this->view->setVar('preNote', NoteBook::getPrevious($nid-1));
        $this->view->setVar('nextNote', NoteBook::getNext($nid+1));
        $this->view->setVar('category', $categorys[$note->category_id]);
    }
    
    public function loadListAction(){
        $this->view->disable();
        
        if( !$this->request->isAjax() ){
            exit('');
        }

        $number = 15;
        $offset = $this->request->getPost('offset', 'int', 0);
        $category = $this->request->getPost('cid', 'int', 0);
        
        $notebook = new NoteBook();
        $records = $notebook->getList($number, $offset, $category);

        $this->view->setVar('records', $records);
        $this->view->partial('notebook/notebook_partial');
        
        return false;
    }

    public function deleteAction(){
        
        $nid = $this->request->getPost('nid', 'int', 0);
        
        try {
            
            $this->checkAjax();
            
            if( !$nid ){
                throw new PhException('EParamError');
            }

            NoteBook::del($nid);

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
        
        $record = NoteBook::findFirst($params[0]);
        
        $this->view->setVar('title', String::msubstr($record->title, 0, 30));
        $this->view->setVar('oldCategory', $record->category_id);
        $this->view->setVar('categorys', Category::getList( Category::CHANNEL_NOTEBOOK ));
        $this->view->setVar('action', $this->url->get('Notebook/updateCategory/' . $record->id));
        
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

            $notebook = new NoteBook();
            $notebook->updateCategory(intval($params[0]), $cid);

            echo Lang::jsonSuccess('SUpdate');
            
        } catch (PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
}