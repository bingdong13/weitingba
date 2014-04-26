<?php

/**
 * 用户登录/登出记录表
 */
class UserLoginLog extends Phalcon\Mvc\Model
{
    const LOG_TYPE_LOGIN = 0; // 登录
    const LOG_TYPE_LOGOUT = 1; // 登出

    /**
     * 记录ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * 记录时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;

    /**
     * 登录/登出IP
     * @Column(type="string", length=15, nullable=true)
     */
    public $client_ip;

    /**
     * 类型，0为登录，1为登出
     * @Column(type="integer", nullable=true)
     */
    public $log_type = 0;
    
    /**
     * 用户Uin
     * @Column(type="integer", nullable=false)
     */
    public $uin;

    public function initialize() {
        $this->useDynamicUpdate(true);
    }
}