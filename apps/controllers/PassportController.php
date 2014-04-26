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
    
    // qq登录
    public function qzoneLoginAction(){
        
        $this->view->disable();
        
        require_once(APP_PATH . '/sdk/qq/qqConnectAPI.php');
        $qc = new QC();
        $qc->qq_login();
    }
    
    // 用户登出
    public function logoutAction() {
        try {

            $this->checkAjax();

            $loginLog = new UserLoginLog();
            $loginLog->uin = $this->userIdentity->getUin();
            $loginLog->client_ip = $this->request->getClientAddress();
            $loginLog->log_type = UserLoginLog::LOG_TYPE_LOGOUT;
            $loginLog->create();

            $this->userIdentity->destroy();

            echo Lang::jsonSuccess('SLogout');

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }
    }

    // 验证账号登录。
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

            $user = UserAccount::findFirst(array(
                'account=:account:',
                'bind' => array('account' => $username)
            ));

            if (!$user) {
                throw new PhException('EUserNotExist');
            }

            if (!$this->security->checkHash($password, $user->password)) {
                throw new PhException('EPasswordError');
            }
            
            $this->_addLoginLogAndSession($user);

            echo Lang::jsonSuccess( 'SLogin', $this->url->get('shared') );

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }
    }
    
    // 验证QQ登录
    public function doQzoneLoginAction(){
        
        $this->view->disable();
        
        require_once(APP_PATH . '/sdk/qq/qqConnectAPI.php');
        
        $qc = new QC();
        $accessToken = $qc->qq_callback();
        $openid = $qc->get_openid();

        $user = UserAccount::findFirst(array(
            'openid=:openid:',
            'bind' => array('openid' => $openid)
        ));

        try {

            if (!$user) { // 注册
                
                $userAccount = new UserAccount();
                $user = $userAccount->qzoneRegister($accessToken, $openid);
            }
            
            $this->_addLoginLogAndSession($user);
            
            // 关闭当前窗口，刷新父窗口。
            echo '<script>window.opener.location.reload();window.close();</script>';

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }
    }

    private function _addLoginLogAndSession($user){
        
        if( !$user->nickname ){
            $user->nickname = $user->account;
        }
        
        $sessinfo = array('uid' => $user->uin, 'nickname' => $user->nickname);
        $this->userIdentity->register($sessinfo);

        $loginLog = new UserLoginLog();
        $loginLog->uin = $user->uin;
        $loginLog->client_ip = $this->request->getClientAddress();
        $loginLog->create();

        return false;
    }
}