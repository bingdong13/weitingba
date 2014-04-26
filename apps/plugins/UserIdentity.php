<?php

class UserIdentity extends \Phalcon\Mvc\User\Plugin
{
    const AURH_KEY = 'wtbUserAuth';
    const STORAGE_SESSION = true;
    
    // 获取用户验证信息
    private function _getAuthInfo(){
        
        $result = null;
        
        if( self::STORAGE_SESSION ){
            
            $result = $this->session->get( self::AURH_KEY );
            
        }else {
            
            $result = $this->cookies->get( self::AURH_KEY )->getValue();
        }
        
        return json_decode( $result );
    }
    
    /**
     * Register authenticated user into session data
     *
     * @param string $info 用户信息
     * @return boolean
     */
    public function register($info) {

        if( self::STORAGE_SESSION ){
            
            $this->session->set(self::AURH_KEY, json_encode($info));
            
        }else {
            
            $this->cookies->set(self::AURH_KEY, json_encode($info));
        }

        return TRUE;
    }
    
    // 销毁session or cookie
    public function destroy(){
        
        if( self::STORAGE_SESSION ){
            
            $this->session->remove( self::AURH_KEY );
            
        }else {
            
            $this->cookies->set(self::AURH_KEY, '', time()-1);
        }

        return TRUE;
    }

    // 判断用户是否登录
    public function isLogin(){
        
        if( self::STORAGE_SESSION ){
            
            return $this->session->has( self::AURH_KEY );
            
        }else {
            
            return $this->cookies->has( self::AURH_KEY );
        }
    }

    // 判断是否系统管理员
    public function isAdmin(){
        if( !$this->isLogin() ){
            return false;
        }

        $user = $this->getUserInfo();
        if($user->role == UserAccount::USER_ROLE_ADMIN){
            return true;
        }

        return false;
    }
    
    // 获取用户Uin
    public function getUin(){
        $user = $this->_getAuthInfo();
        
        return $user ? $user->uid : 0;
    }
    
    // 获取用户昵称
    public function getNickname(){
        $user = $this->_getAuthInfo();

        return $user ? $user->nickname : '';
    }
    
    // 获取登录用户信息
    public function getUserInfo(){

        $user = UserAccount::getUserAccount( $this->getUin() );

        $user->face || $user->face = 'face_default.jpeg';
        
        $user->face = $this->config->url->img . $user->face;

        return $user;
    }
    
    // 用户身份验证
    public function authenticate() {
        
        $role = 'Guests';
                
        if( !$this->isLogin() ){
            return $role;
        }
        
        $user = UserAccount::getUserAccount($this->getUin());

        if( empty($user) ){
            return $role;
        }
            
        switch( (int)$user->role ){
            case UserAccount::USER_ROLE_MEMBER :
                $role =  'Member';
                break;
            case UserAccount::USER_ROLE_ADMIN :
                $role =  'Admin';
                break;
            default :
                break;
        }
        
        return $role;
    }
}
