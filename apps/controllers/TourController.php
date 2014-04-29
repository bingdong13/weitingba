<?php

use \Phalcon\Exception as PhException;

class TourController extends ControllerBase {

    public function initialize() {
        parent::initialize();

        $this->style->addCss('/css/fm.css');
        $this->script->addJs('/js/fm.js');
        
        $isAdmin = $this->userIdentity->isAdmin();
        $this->view->setVar('isAdmin', $isAdmin);

        if( $isAdmin ){
            $this->style->addCss('/uploadify/uploadify.css');
            $this->script->addJs('/uploadify/jquery.uploadify.min.js');
        }
    }

    public function indexAction() {

        $tour = new Tour();
        $record = $tour->getLast();
        if( !empty($record) ){

            if( !$record->bg_url ){
                $record->bg_url = $this->config->url->img . 'bg_default.jpg';
            }else{
                $record->bg_url = $this->config->url->img . $record->bg_url;
            }

            $this->tag->prependTitle($record->title);
            
            $this->view->setVar('keywords', $record->keywords);
            $this->view->setVar('descript', $record->description);

            $this->view->setVar('more', true);
            $this->view->setVar('records', $tour->getList(30, 0));

        }else{
            $this->tag->prependTitle(Lang::tip('TTour'));
        }

        $this->view->setVar('record', $record);
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
    }

}