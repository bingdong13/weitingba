<?php

use \Phalcon\Exception as PhException;

class SystemController extends ControllerBase
{
    public function initialize() {
        parent::initialize();

        $this->style->addCss('/css/backend.css');
        $this->script->addJs('/js/backend.js');

        $this->tag->prependTitle('系统管理');

        $this->view->setTemplateAfter('backend');
    }

    public function indexAction(){
        $this->view->disable();
        echo '后台管理';
    }

    public function cacheAction(){
        $cacheRes = $this->modelsCache->queryKeys();

        $this->view->setVar('ptitle', Lang::tip('TCacheList') );
        $this->view->setVar('record', $cacheRes);
    }

    public function cleanCacheAction(){

        try {

            $this->checkAjax();

            $key = trim($this->request->getPost('key'));
            
            if($key){

                $this->modelsCache->delete( $key );

            }else{
                
                $this->modelsCache->flush();
            }

            echo Lang::jsonSuccess('SUpdate');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function backdropAction(){

        $param = $this->dispatcher->getParams();
        $cpage = intval($param[0]) ? $param[0] : 1;

        $total_items = Backdrop::count();
        if( $total_items ){
            
            $listRows = 30;
            $offset   = ($cpage -1) * $listRows;

            $records = Backdrop::find(array(
                'order' => 'site,id DESC',
                'limit' => array('number' => $listRows, 'offset' => $offset)
            ));

            $page = new Page ($total_items, $cpage, $listRows);
            $pnav = $page->showByUrl($this->url->get('system/backdrop'));
        }else{
            $records = array();
            $pnav = '';
        }

        $this->view->setVar('records', $records);
        $this->view->setVar('pagenav', $pnav);
        $this->view->setVar('sites', Backdrop::$sites);
        $this->view->setVar('ptitle', Lang::tip('TBackdrop') );
    }

    public function memberAction(){
        $param = $this->dispatcher->getParams();
        $cpage = intval($param[0]) ? $param[0] : 1;

        $total_items = UserAccount::count();
        if( $total_items ){
            
            $listRows = 30;
            $offset   = ($cpage -1) * $listRows;

            $records = UserAccount::find(array(
                'order' => 'role DESC, uin DESC',
                'limit' => array('number' => $listRows, 'offset' => $offset)
            ));

            $page = new Page ($total_items, $cpage, $listRows);
            $pnav = $page->showByUrl($this->url->get('system/member'));
        }else{
            $records = array();
            $pnav = '';
        }

        $this->view->setVar('ptitle', Lang::tip('TMember') );
        $this->view->setVar('records', $records);
        $this->view->setVar('pagenav', $pnav);
    }

    public function delMemberAction(){
        
        $uid = $this->request->getPost('uid', 'int', 0);

        try {
            
            $this->checkAjax();
            
            if( !$uid ){
                throw new PhException('EParamError');
            }

            UserAccount::del($uid);

            echo Lang::jsonSuccess('SDelete');
            
        } catch (PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
}