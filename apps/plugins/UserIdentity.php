<?php

class UserIdentity extends \Phalcon\Mvc\User\Plugin
{
    const AURH_KEY = 'wtbUserAuth';
    const STORAGE_SESSION = true;
    
    public function authenticate() {

        return $this->isLogin() ? 'Admin' : 'Guests';
    }
    
    /**
     * Register authenticated user into session data
     *
     * @param string $account 用户账号
     * @return boolean
     */
    public function register($account) {

        if( self::STORAGE_SESSION ){
            
            $this->session->set(self::AURH_KEY, $account);
            
        }else {
            
            $this->cookies->set(self::AURH_KEY, $account);
        }

        return TRUE;
    }
    
    public function destroy(){
        
        if( self::STORAGE_SESSION ){
            
            $this->session->remove( self::AURH_KEY );
            
        }else {
            
            $this->cookies->set(self::AURH_KEY, '', time()-1);
        }

        return TRUE;
    }

    public function isLogin(){
        
        if( self::STORAGE_SESSION ){
            
            return $this->session->has( self::AURH_KEY );
            
        }else {
            
            return $this->cookies->has( self::AURH_KEY );
        }
    }
    
    public function getUin(){
        $user = $this->getUserInfo();
        
        return $user->uin;
    }
    
    public function getAccount(){
        
        $result = null;
        
        if( self::STORAGE_SESSION ){
            
            if( $this->session->has( self::AURH_KEY ) ){
                $result = $this->session->get( self::AURH_KEY );
            }
            
        }else {
            
            if( $this->cookies->has( self::AURH_KEY ) ){
                $result = $this->cookies->get( self::AURH_KEY )->getValue();
            }
        }
        
        return $result;
    }
    
    // 获取登录用户或站长信息
    public function getUserInfo(){

        if( $this->isLogin() ){
            
            // 登录用户
            $account = $this->getAccount();
            
        }else{
            
            // 站长
            $account = $this->config->application->siter;
        }

        $user = UserAccount::getUserInfo($account);
        if( empty($user) ){
            return null;
        }

        $user->filename = $user->face;

        if(empty($user->face)){
            $user->face = $this->config->url->img . 'face_default.jpeg';
        }else{
            $user->face = $this->config->url->img . $user->face;
        }

        $user->gender = $user->gender=='M' ? '男' : '女';

        return $user;
    }
}
