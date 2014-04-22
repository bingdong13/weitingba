<?php

use \Phalcon\Exception as PhException;

class IndexController extends ControllerBase {

    public function initialize() {
        parent::initialize();

        $this->style->addCss('/css/fm.css');
        $this->script->addJs('/js/fm.js');
    }

    public function indexAction() {

        $isLogin = $this->userIdentity->isLogin();
        $this->view->setVar('isLogin',$isLogin);

        if( $isLogin ){
            $this->style->addCss('/uploadify/uploadify.css');
            $this->script->addJs('/uploadify/jquery.uploadify.min.js');
        }

        $this->script->addJs('/js/jquery.fillmore.min.js');

        $backdrop = Backdrop::get(Backdrop::SITE_HOME);
        if( !$backdrop ){
            $bg_url = $this->config->url->img . 'bg_default.jpg';
        }else{
            $bg_url = $this->config->url->img . $backdrop->url;
        }

        $this->view->setVar('bg_url', $bg_url);

        $record = Billboard::getLast();
        if( !empty($record) ){
            $this->view->setVar('keywords', $record->sign);
            $this->view->setVar('descript', $record->content);
        }

        $this->view->setVar('record', $record);
    }

    public function fmAction() {

        $this->tag->prependTitle($this->config->channel->fm->title);
        
        $fm = new Fm();
        $record = $fm->getLast();
        if( !empty($record) ){

            $record->access_times += $fm->increment( $record->id );
            $record->total = Fm::count();

            if( !$record->bg_url ){
                $record->bg_url = $this->config->url->img . 'bg_default.jpg';
            }else{
                $record->bg_url = $this->config->url->img . $record->bg_url;
            }

            $this->view->setVar('keywords', $record->keywords);
            $this->view->setVar('descript', $record->description);
        }
        
        $this->view->setVar('record', $record);

        $isLogin = $this->userIdentity->isLogin();
        $this->view->setVar('isLogin', $isLogin);
        
        $this->script->addJs('/js/jquery.fillmore.min.js')
                     ->addJs('/audiojs/audio.min.js');

        if( $isLogin ){
            $this->style->addCss('/uploadify/uploadify.css');
            $this->script->addJs('/uploadify/jquery.uploadify.min.js');
        }
    }
    
    public function loadfmAction(){
        
        try {
            
            $this->checkAjax();
            
            $fid = $this->request->getPost('fid', 'int', 0);
            if ( !$fid ) {
                throw new PhException('EParamError');
            }
            
            $fm = new Fm();
            $record = $fm->get( $fid );
            if ( empty($record) ) {
                throw new PhException('EShareNotExist');
            }

            $record->access_times += $fm->increment($record->id);
            $record->bg_url = $this->config->url->img . $record->bg_url;
            
            echo json_encode($record);
            
        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
    
    public function loadfmlistAction(){
        $this->view->disable();
        
        if( !$this->request->isAjax() ){
            exit('');
        }
        
        $offset = $this->request->getPost('offset', 'int', 0);
        $number = 10;
        
        $fm = new Fm();
        $this->view->setVar('records', $fm->getList($number, $offset));
        
        $this->view->partial('index/fmList');
    }

    public function aboutAction(){

        $this->view->disable();

        $siter = $this->userIdentity->getUserInfo();

        $date = new Date($siter->birthday);
        $siter->magic = $date->magicInfo('XZ');

        $this->view->setVar('siter', $siter );
        
        $this->view->partial('index/about');
    }
}