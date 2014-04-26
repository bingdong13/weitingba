<?php

use \Phalcon\Exception as PhException;

class GuestbookController extends ControllerBase
{
    public function initialize(){
        parent::initialize();

        $this->style->addCss('/css/black.css');
        $this->script->addJs('/js/guestbook.js');
    }

    public function indexAction() {
        
        $this->tag->prependTitle(Lang::tip('TGuestbook'));

        $siter = UserAccount::getUserAccount(1);
        $siter->face || $siter->face = 'face_default.jpeg';
        
        $siter->face = $this->config->url->img . $siter->face;

        $this->view->setVar('siter', $siter);
        $this->view->setVar('isLogin', $this->userIdentity->isLogin());
    }

    public function loadListAction(){
        $this->view->disable();
        
        if( !$this->request->isAjax() ){
            exit('');
        }

        $number = 15;
        $offset = $this->request->getPost('offset', 'int', 0);

        $records = GuestBook::getList($number, $offset);
        if(empty($records)){
           exit('');
        }

        $this->view->setVar('records', $records);

        $this->view->partial('guestbook/msg_partial');
        
        return false;
    }

    public function loadReplyAction(){
        $this->view->disable();
        
        if( !$this->request->isAjax() ){
            exit(Lang::tip('EAjaxSubmit'));
        }

        $pid = $this->request->getQuery('pid', 'int', 0);
        if(empty($pid)){
           exit(Lang::tip('EParamError'));
        }

        $this->view->setVar('records', GuestBook::getReplyList($pid));

        $this->view->partial('guestbook/reply_partial');
        
        return false;
    }
    
    public function addAction(){
        try {

            $this->checkAjax();
            
            $content = $this->request->getPost('content');
            $pid = $this->request->getPost('pid', 'int', 0);
            
            if ( !$content ) {
                throw new PhException('EShareIsEmpty');
            }

            $gbook = new GuestBook();
            $gbook->content = $content;
            $gbook->parent_id = $pid;
            $gbook->clinet_ip = $this->request->getClientAddress();
            $gbook->uin = $this->userIdentity->getUin();
            if( $gbook->create() === false ) {
                throw new PhException('ESystemError');
            }

            echo Lang::jsonSuccess('SPublish');

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function deleteAction(){
        
        $gid = $this->request->getPost('gid', 'int', 0);
        
        try {
            
            $this->checkAjax();
            
            if( !$gid ){
                throw new PhException('EParamError');
            }

            GuestBook::del($gid);

            echo Lang::jsonSuccess('SDelete');
            
        } catch (PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
}