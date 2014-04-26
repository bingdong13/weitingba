<?php

use \Phalcon\Exception as PhException;

class AccountController extends ControllerBase
{
    public function initialize() {
        parent::initialize();
    }

    public function indexAction(){

        $this->style->addCss('/css/backend.css')
                ->addCss('/uploadify/uploadify.css');
        
        $this->script->addJs('/uploadify/jquery.uploadify.min.js');
        
        $this->tag->prependTitle('个人资料');
        
        $user = $this->userIdentity->getUserInfo();
        
        $isInitialPwd = $this->security->checkHash($user->account, $user->password);
        
        $this->view->setVar('isInitialPwd', $isInitialPwd);
        $this->view->setVar('user', $user);
    }
    
    public function saveUserInfoAction(){
        try {

            $this->checkAjax();

            $nickname = trim($this->request->getPost('nickname'));
            $password = trim($this->request->getPost('new_password'));
            $face = trim($this->request->getPost('face'));
            
            $user = UserAccount::findFirst(array(
                'uin = :uin:',
                'bind' => array('uin' => $this->userIdentity->getUin())
            ));

            if (!$user) {
                throw new PhException('EUserNotExist');
            }
            
            $isUpdate = false;
            if ( $nickname &&  $nickname != $user->nickname) {
                $user->nickname = $nickname;
                $isUpdate = true;
            }
            
            if ( $password && !$this->security->checkHash($password, $user->password)) {
                $user->password = $this->security->hash($password);
                $isUpdate = true;
            }
            
            if ( $face ) {
                $user->face = $face;
                $isUpdate = true;
            }
            
            if( $isUpdate ){
                if($user->update() === false){
                    throw new PhException('ESystemError');
                }
            }

            echo Lang::jsonSuccess('SUpdate');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }
    }
}