<?php

use \Phalcon\Exception as PhException;

class PassportController extends ControllerBase
{

    public function initialize() {
        parent::initialize();
        
        $this->style->addCss('/css/passport.css');
    }
    
    // 用户登录
    public function loginAction() {
        if( $this->userIdentity->isLogin() ){
            $this->response->redirect('shared');
            return false;
        }

        $this->tag->prependTitle(Lang::tip('TUserLogin'));
    }
    
    // ajax登录
    public function ajaxLoginAction() {
        
        $this->view->disable();
        
        $this->view->partial('passport/ajaxLogin');
    }
    
    // 用户登出
    public function logoutAction() {
        try {

            $this->checkAjax();

            $this->userIdentity->destroy();

            echo Lang::jsonSuccess('SLogout');

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    // 验证登录。
    public function doLoginAction(){
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        try {

            $this->checkAjaxForm();

            if(!$username){
                throw new PhException('EAccountIsEmpty');
            }

            if(!$password){
                throw new PhException('EPasswordIsEmpty');
            }

            $userAccount = new UserAccount();
            $userAccount->login($username, $password);

            echo Lang::jsonSuccess( 'SLogin', $this->url->get('shared') );

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }
        
        return false;
    }
}