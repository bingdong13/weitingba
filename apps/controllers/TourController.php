<?php

use \Phalcon\Exception as PhException;

class TourController extends ControllerBase {

    public function initialize() {
        parent::initialize();

        $this->style->addCss('/css/fm.css');
        $this->script->addJs('/js/fm.js');
    }

    public function indexAction() {

        $tour = new Tour();
        $record = $tour->getLast();
        if( !empty($record) ){

            $record->access_times += $tour->increment( $record->id );

            if( !$record->bg_url ){
                $record->bg_url = $this->config->url->img . 'bg_default.jpg';
            }else{
                $record->bg_url = $this->config->url->img . $record->bg_url;
            }

            $this->tag->prependTitle($record->title);
            
            $this->view->setVar('keywords', $record->keywords);
            $this->view->setVar('descript', $record->description);

            $this->view->setVar('ref', $this->url->get('tour@' . $record->id));
            $this->view->setVar('records', $tour->getList(30, 0));

        }else{
            $this->tag->prependTitle(Lang::tip('TTour'));
        }

        $this->view->setVar('record', $record);

        $isLogin = $this->userIdentity->isLogin();
        $this->view->setVar('isLogin', $isLogin);

        if( $isLogin ){
            $this->style->addCss('/uploadify/uploadify.css');
            $this->script->addJs('/uploadify/jquery.uploadify.min.js');
        }
    }

    public function infoAction(){

        $tid = $this->dispatcher->getParam('tid');
        if( !intval($tid) ){
            $this->forward('error/show404');
            return false;
        }

        $tour = new Tour();
        $record = $tour->get($tid);

        if( empty($record) ){
            $this->forward('error/show404');
            return false;
        }

        $isLogin = $this->userIdentity->isLogin();
        $this->view->setVar('isLogin', $isLogin);

        if( $isLogin ){
            $this->style->addCss('/uploadify/uploadify.css');
            $this->script->addJs('/uploadify/jquery.uploadify.min.js');
        }

        $this->tag->prependTitle($record->title);

        $record->access_times += $tour->increment( $record->id );
        
        if( !$record->bg_url ){
            $record->bg_url = $this->config->url->img . 'bg_default.jpg';
        }else{
            $record->bg_url = $this->config->url->img . $record->bg_url;
        }
        
        $this->view->setVar('record', $record);
        $this->view->setVar('prev', $tour->getPrevious($record->id));
        $this->view->setVar('next', $tour->getNext($record->id));
        $this->view->setVar('records', TourPhoto::getList($record->id));
        $this->view->setVar('ref', '#read');
    }

}