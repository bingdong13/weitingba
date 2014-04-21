    <?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 用户账号
 */
class UserAccount extends PhModel
{
    const CACHE_USER_ACCOUNT_KEY = 'CUser:account:';
    
    /**
     * 用户ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $uin;

    /**
     * 用户账号
     * @Column(type="string", length=45, nullable=false)
     */
    public $account;

    /**
     * 登录密码
     * @Column(type="string", length=60, nullable=false)
     */
    public $password;

    /**
     * 昵称
     * @Column(type="string", length=45, nullable=true)
     */
    public $nickname;

    /**
     * 头像
     * @Column(type="string", length=45, nullable=true)
     */
    public $face;

    /**
     * 性别，M为男性，F为女性
     * @Column(type="string", nullable=false)
     */
    public $gender = 'M';

    /**
     * 生日
     * @Column(type="string", nullable=true)
     */
    public $birthday;

    /**
     * 地址
     * @Column(type="string", length=45, nullable=true)
     */
    public $address;

    /**
     * 自我介绍
     * @Column(type="string", length=300, nullable=true)
     */
    public $introduce;

    protected function afterUpdate(){
        // clean cache
        $cache = $this->getDI()->getModelsCache();
        $cache->delete( self::CACHE_USER_ACCOUNT_KEY . $this->account );
        
        return TRUE;
    }

    public function initialize() {
        $this->useDynamicUpdate(true);
    }

    /**
     * 保存登录信息
     * 
     * @access public
     * @param string $username 账号
     * @param string $password 密码
     * @return boolean
     */
    public function login($username, $password){
        $di = $this->getDI();
        $security = $di->getSecurity();

        $user = $this->findFirst(array(
            'account=:account:',
            'bind' => array('account' => $username)
        ));

        if (!$user) {
            throw new PhException('EUserNotExist');
        }

        if (!$security->checkHash($password, $user->password)) {
            throw new PhException('EPasswordError');
        }
        
        $di->getUserIdentity()->register($username);

        return TRUE;
    }

    /**
     * 更新用户信息
     * 
     * @param integer $uin 用户Uin
     * @param string $data 要更新的数据
     * @return boolean
     */
    public function updateInfo($uin, $data){

        $user = $this->findFirst(array(
            'uin = :uin:',
            'bind' => array('uin' => $uin)
        ));

        if( !$user ){
            throw new PhException('EUserNotExist');
        }

        if ( $user->update($data) === false ) {
            
            throw new PhException('ESystemError');
        }
        
        return TRUE;
    }
    
    /**
     * 更新用户密码
     * 
     * @param integer $uin 用户Uin
     * @param string $old 旧密码
     * @param string $new 新密码
     * @return boolean
     */
    public function updatePasswd($uin, $oldPasswd, $newPasswd){

        $user = self::findFirst(array(
            'uin = :uin:',
            'bind' => array('uin' => $uin)
        ));

        if (!$user) {
            throw new PhException('EUserNotExist');
        }

        $security = $this->getDI()->getSecurity();
        if (! $security->checkHash($oldPasswd, $user->password)) {
            throw new PhException('EPasswordNotMatch');
        }
        
        $user->password = $security->hash($newPasswd);
        if($user->update() === false){
            throw new PhException('ESystemError');
        }
        
        return TRUE;
    }

    /**
     * 获取用户详细资料
     * @static
     * @access public
     * @return object
     */
    static public function getUserInfo($account){

        return self::findFirst(array(
            'account = :account:',
            'bind' => array( 'account' => $account),
            'cache' => array('key' => self::CACHE_USER_ACCOUNT_KEY . $account)
        ));
    }
}