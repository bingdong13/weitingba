<?php

use \Phalcon\Exception as PhException;

class AccountController extends ControllerBase
{
    public function initialize() {
        parent::initialize();

        $this->style->addCss('/css/backend.css');
        $this->script->addJs('/js/backend.js');

        $this->tag->prependTitle('个人资料');

        $this->view->setTemplateAfter('backend');

        $this->user = $this->userIdentity->getUserInfo();
        $this->view->setVar('user', $this->user);
    }

    public function indexAction(){
        $this->style->addCss('/jquery-ui/jquery-ui.min.css')
                ->addCss('/uploadify/uploadify.css');
        $this->script->addJs('/jquery-ui/jquery-ui.min.js')
                ->addJs('/uploadify/jquery.uploadify.min.js')
                ->addJs('/uploadify/jquery.Jcrop.min.js');

        $this->view->setVar('ptitle', Lang::tip('TEditAccount') );
    }
    
    public function passwordAction(){
        $this->view->setVar('ptitle',  Lang::tip('TEditPassword') );
    }
    
    public function saveUserInfoAction(){
        try {

            $this->checkAjax();

            $info = $this->request->getPost('info');

            if ( !$info ) {
                throw new PhException('EParamError');
            }

            $userAccount = new UserAccount();
            $userAccount->updateInfo($this->user->uin, $info);

            echo Lang::jsonSuccess('SUpdate');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function savePasswordAction(){
        try {

            $this->checkAjaxForm();
        
            $oldPassword = $this->request->getPost('old_password');
            $newPassword = $this->request->getPost('new_password');
            
            if(!$oldPassword){

                throw new PhException('EOldPasswordIsEmpty');
            }

            if(!$newPassword){
                
                throw new PhException('ENewPasswordIsEmpty');
            }

            $user = new UserAccount();
            $user->updatePasswd($this->user->uin, $oldPassword, $newPassword);

            echo Lang::jsonSuccess( 'SUpdate' );
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }
        
        return false;
    }
}