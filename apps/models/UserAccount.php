    <?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 用户账号
 */
class UserAccount extends PhModel
{
    const USER_ROLE_MEMBER = 1; // 普通会员
    const USER_ROLE_ADMIN = 99; // 系统管理员
    
    const USER_TYPE_LOCAL = 'local'; // 本站
    const USER_TYPE_QQ = 'qq'; // qq
    
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
    public $nickname = '';

    /**
     * 头像
     * @Column(type="string", length=255, nullable=true)
     */
    public $face = '';
    
    /**
     * 角色 1 普通会员; 99 系统管理员;
     * @Column(type="integer", nullable=true)
     */
    public $role = 1;
    
    /**
     * 开放平台ID
     * @Column(type="string", length=64, nullable=true)
     */
    public $openid = '';
    
    /**
     * 来源 local 本地; admin 系统管理员;
     * @Column(type="string", length=10, nullable=true)
     */
    public $ctype = 1;

    /**
     * 注册时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;
    
    protected function afterUpdate(){
        // clean cache
        $cache = $this->getDI()->getModelsCache();
        $cache->delete( self::CACHE_USER_ACCOUNT_KEY . $this->uin );
        
        return TRUE;
    }

    public function initialize() {
        $this->useDynamicUpdate(true);
    }

    /**
     * 保存QQ注册信息
     *
     * @access public
     * @param string $accessToken 账号
     * @param string $openid
     */
    public function qzoneRegister($accessToken, $openid){

        $security = $this->getDI()->getSecurity();

        // 获取qq用户信息
        $qc = new QC($accessToken, $openid);
        $qqInfo = $qc->get_user_info();
        
        $face_url = $qqInfo['figureurl_qq_2'] ? $qqInfo['figureurl_qq_2'] : $qqInfo['figureurl_2'];
        
        $storage = new Storage();
        
        $qqUserNum = self::maximum(array(
            'column' => 'account',
            'ctype=:ctype:',
            'bind' => array('ctype' => self::USER_TYPE_QQ)
        ));

        $this->account = sprintf("%05d", ($qqUserNum ? $qqUserNum+1 : 20000) );
        $this->password = $security->hash($this->account);
        $this->role = self::USER_ROLE_MEMBER;
        $this->ctype = self::USER_TYPE_QQ;
        $this->openid = $openid;
        $this->face = $storage->downloadImg($face_url);
        $this->nickname  = $qqInfo["nickname"];

        if($this->create() === false){

            throw new PhException('EQQRegError');
        }
        
        return $this;
    }

    /**
     * 获取用户账号
     * @static
     * @access public
     * @return object
     */
    static public function getUserAccount($uid){

        return self::findFirst(array(
            'uin = :uin:',
            'bind' => array( 'uin' => $uid),
            'cache' => array('key' => self::CACHE_USER_ACCOUNT_KEY . $uid)
        ));
    }

    /**
     * 删除记录
     * 
     * @param integer $sid 记录ID
     * @return boolean
     * @throws PhException
     */
    static public function del($sid){
        
        $record = self::findFirst($sid);

        if( !$record ){
            throw new PhException('EShareNotExist');
        }

        if( $record->delete() === false ){
            throw new PhException('ESystemError');
        }

        return TRUE;
    }
}