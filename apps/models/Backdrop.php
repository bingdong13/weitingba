<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 布景 model
 */
class Backdrop extends PhModel
{
    const SITE_HOME = 1; // 首页
    const SITE_TOUR = 2; //旅游

    const CACHE_BACKDROP_KEY = 'CBackdrop:';
    const CACHE_BACKDROP_SITE_KEY = 'CBackdrop:site:';
    
    /**
     * 记录ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * 所属位置
     * @Column(type="integer", nullable=false)
     */
    public $site;
    
    /**
     * 背景图
     * @Column(type="string", length=255, nullable=true)
     */
    public $url;

    /**
     * 发布时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;

    protected function afterCreate() {

        $cache = $this->getDI()->getModelsCache();
  
        $cache->delete( self::CACHE_BACKDROP_SITE_KEY . $this->site );

        return true;
    }

    protected function afterDelete() {

        $cache = $this->getDI()->getModelsCache();
  
        $cache->delete( self::CACHE_BACKDROP_KEY . $this->id );

        return true;
    }

    static public $sites = array(
        self::SITE_HOME => '首页',
        self::SITE_TOUR => '旅游'
    );

    public function initialize() {}

    /**
     * 获取单条记录
     *
     * @param integer $nid 记录ID
     * @return object
     */
    static public function get($site){

        if( !intval($site) ){
            return null;
        }

        return self::findFirst(array(
            'site=:site:',
            'bind' => array('site' => $site ),
            'order' => 'id DESC',
            'cache' => array('key' => self::CACHE_BACKDROP_SITE_KEY . $site)
        ));
    }
    
    /**
     * 删除记录
     * 
     * @param integer $nid 记录ID
     * @return boolean
     */
    static public function del($nid){
        
        $record = self::findFirst($nid);

        if( !$record ){
            throw new PhException('EShareNotExist');
        }

        if( $record->delete() === false ){
            throw new PhException('ESystemError');
        }

        return TRUE;
    }
}