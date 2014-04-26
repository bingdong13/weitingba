<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 旅游主题 model
 */
class Tour extends PhModel
{
    const CACHE_TOUR_LIST_KEY = 'CTour:list:';
    const CACHE_TOUR_KEY = 'CTour:single:';
    const CACHE_TOUR_LAST_KEY = 'CTour:last:';
    const CACHE_TOUR_TIMES_KEY = 'CTour:read:times:';
    
    /**
     * 记录ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * 标题
     * @Column(type="string", length=100, nullable=false)
     */
    public $title;

    /**
     * 关键字
     * @Column(type="string", length=150, nullable=true)
     */
    public $keywords;

    /**
     * 简介
     * @Column(type="string", length=255, nullable=true)
     */
    public $description;
    
    /**
     * 缩略图
     * @Column(type="string", length=255, nullable=true)
     */
    public $face_url;
    
    /**
     * 背景图
     * @Column(type="string", length=255, nullable=true)
     */
    public $bg_url = '';

    /**
     * 来源
     * @Column(type="string", length=90, nullable=true)
     */
    public $comeform;

    /**
     * 发布时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;

    /**
     * 更新时间
     * @Column(type="string", nullable=true)
     */
    public $update_time;

    /**
     * 播放次数
     * @Column(type="integer", nullable=false)
     */
    public $access_times = 0;

    /**
     * 状态，0 不公开，1 公开
     * @Column(type="integer", nullable=false)
     */
    public $status = 1;

    /**
     * 排序
     * @Column(type="integer", nullable=true)
     */
    public $sort=1;

    protected function beforeSave(){
        $this->update_time = date('Y-m-d H:i:s');
    }
    
    protected function afterSave(){
        $this->deleteListCache();

        return true;
    }

    public function beforeDelete() {

        return TourPhoto::delByTourId($this->id);
    }

    protected function afterDelete() {
        
        $this->deleteListCache();

        return true;
    }

    // 删除cache
    protected function deleteListCache(){
        $cache = $this->getDI()->getModelsCache();
        
        $listCache = $cache->queryKeys(self::CACHE_TOUR_LIST_KEY);
        foreach($listCache as $val){
            $cache->delete( $val );
        }

        $singleCache = $cache->queryKeys(self::CACHE_TOUR_KEY . $this->id);
        foreach($singleCache as $val){
            $cache->delete( $val );
        }
        
        $cache->delete( self::CACHE_TOUR_LAST_KEY );
    }

    public function initialize() {
        $this->useDynamicUpdate(true);
    }

    /**
     * 获取单条记录
     *
     * @param integer $nid 记录ID
     * @return object
     */
    static public function get($nid){

        if( !intval($nid) ){
            return null;
        }

        return self::findFirst(array(
            'id=:nid: and status=:status:',
            'bind' => array('nid' => $nid, 'status' => 1 ),
            'cache' => array('key' => self::CACHE_TOUR_KEY . $nid)
        ));
    }

    /**
     * 获取上一条记录
     *
     * @param integer $nid 记录ID
     * @return object
     */
    static public function getPrevious($nid){

        if( !intval($nid) ){
            return null;
        }

        return self::findFirst(array(
            'id<:nid: and status=:status:',
            'bind' => array('nid' => $nid, 'status' => 1 ),
            'order' => 'id DESC',
            'cache' => array('key' => self::CACHE_TOUR_KEY . $nid . ':previous')
        ));
    }
    

    /**
     * 获取下一条记录
     *
     * @param integer $nid 记录ID
     * @return object
     */
    static public function getNext($nid){

        if( !intval($nid) ){
            return null;
        }

        return self::findFirst(array(
            'id>:nid: and status=:status:',
            'bind' => array('nid' => $nid, 'status' => 1 ),
            'cache' => array('key' => self::CACHE_TOUR_KEY . $nid . ':next')
        ));
    }
    
    /**
     * 获取最新一条记录
     * 
     * @return object
     */
    static public function getLast(){

        return self::findFirst(array(
            'status=:status:',
            'bind' => array('status' => 1 ),
            'order' => 'sort,id DESC',
            'cache' => array('key' => self::CACHE_TOUR_LAST_KEY)
        ));
    }
    
    /**
     * 获取记录列表
     *
     * @param integer $number 记录数
     * @param integer $offset 步长
     * @return array
     */
    public function getList($number, $offset){
        $param = array(
            'status=:status:',
            'bind' => array('status' => 1 ),
            'order' => 'sort, id DESC',
            'limit' => array('number' => $number, 'offset' => $offset),
            'cache' => array('key' => self::CACHE_TOUR_LIST_KEY . "{$number}:{$offset}")
        );
        
        $records = $this->find($param);
        if( !$records ){
            return array();
        }

        $records = $records->toArray();

        $cache = $this->getDI()->getModelsCache();

        foreach($records as &$row){
            $cachekey = self::CACHE_TOUR_TIMES_KEY . $row['id'];
            $row['access_times'] += $cache->get( $cachekey );
        }
        
        return $records;
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

    /**
     * 增加访问次数
     * 
     * @param integer $id 记录ID
     * @param integer $times 阅读次数
     * @return integer 返回最新阅读次数
     */
    public function increment($id, $times=1){
        $maxSize = 5; // cache中累加次数最大值

        $cache = $this->getDI()->getModelsCache();

        $key = self::CACHE_TOUR_TIMES_KEY . $id;

        if( $cache->exists($key) ){
            $times += $cache->get( $key );

            // 当cache中次数达到最大值时，更新db
            // 并重置cache中次数为0。
            if($times > $maxSize){
                $record = $this->findFirst($id);
                $record->access_times += $times;
                $record->update();

                $cache->save($key, 0);
            }else{
                $times = $cache->increment($key);
            }
        }else{
            $cache->save($key, $times);
        }

        return $times;
    }
}