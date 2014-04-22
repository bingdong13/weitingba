<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * Fm model
 */
class Fm extends PhModel
{
    const CACHE_FM_LIST_KEY = 'CFm:list:';
    const CACHE_FM_KEY = 'CFm:single:';
    const CACHE_FM_LAST_KEY = 'CFm:last:';
    const CACHE_FM_TIMES_KEY = 'CFm:read:times:';
    
    const FM_TYPE_MUSIC = 1; // 音乐
    const FM_TYPE_DRAMA = 2; // 广播剧
    const FM_TYPE_RADIO = 3; // 收音机
    
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
     * 主播/歌手
     * @Column(type="string", length=100, nullable=false)
     */
    public $anchor;

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
     * 音频
     * @Column(type="string", length=255, nullable=true)
     */
    public $voice;

    /**
     * 内容
     * @Column(type="string", nullable=true)
     */
    public $content;

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
     * 状态，0 开播，1 停播
     * @Column(type="integer", nullable=false)
     */
    public $status = 0;

    /**
     * 所属类别
     * @Column(type="integer", nullable=false)
     */
    public $category_id;
    
    /**
     * 所属类型
     * FM_TYPE_MUSIC = 1;  // 音乐
     * FM_TYPE_DRAMA = 2;  // 广播剧
     * FM_TYPE_RADIO = 3; // 收音机
     * 
     * @Column(type="integer", nullable=false)
     */
    public $ftype;
    
    static public $fmType = array(
        self::FM_TYPE_MUSIC => '音乐',
        self::FM_TYPE_DRAMA => '广播剧',
        self::FM_TYPE_RADIO => '收音机'
    );

    protected function beforeSave(){
        $this->update_time = date('Y-m-d H:i:s');
    }
    
    protected function afterCreate(){
        $this->deleteListCache();

        // 更新分类的条目数
        $category = Category::findFirst( $this->category_id );
        $category->numbers += 1;
        $category->update();

        return true;
    }

    protected function afterUpdate(){
        $this->deleteListCache();

        return true;
    }

    protected function afterDelete() {
        $this->deleteListCache();

        // 更新分类的条目数
        $category = Category::findFirst( $this->category_id );
        if($category->numbers > 0){
            $category->numbers -= 1;
            $category->update();
        }

        return true;
    }

    // 删除cache
    protected function deleteListCache(){
        $cache = $this->getDI()->getModelsCache();
        
        $listCache = $cache->queryKeys(self::CACHE_FM_LIST_KEY);
        foreach($listCache as $val){
            $cache->delete( $val );
        }

        $singleCache = $cache->queryKeys(self::CACHE_FM_KEY . $this->id);
        foreach($singleCache as $val){
            $cache->delete( $val );
        }
        
        $cache->delete( self::CACHE_FM_LAST_KEY );
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
            'bind' => array('nid' => $nid, 'status' => 0 ),
            'cache' => array('key' => self::CACHE_FM_KEY . $nid)
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
            'bind' => array('nid' => $nid, 'status' => 0 ),
            'order' => 'id DESC',
            'cache' => array('key' => self::CACHE_FM_KEY . $nid . ':previous')
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
            'bind' => array('nid' => $nid, 'status' => 0 ),
            'cache' => array('key' => self::CACHE_FM_KEY . $nid . ':next')
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
            'bind' => array('status' => 0 ),
            'order' => 'id DESC',
            'cache' => array('key' => self::CACHE_FM_LAST_KEY)
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
            'bind' => array('status' => 0 ),
            'order' => 'id DESC',
            'limit' => array('number' => $number, 'offset' => $offset),
            'cache' => array('key' => self::CACHE_FM_LIST_KEY . "{$number}:{$offset}")
        );
        
        $records = $this->find($param);
        if( !$records ){
            return array();
        }

        $records = $records->toArray();

        $cache = $this->getDI()->getModelsCache();

        foreach($records as &$row){
            $cachekey = self::CACHE_FM_TIMES_KEY . $row['id'];
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

        $key = self::CACHE_FM_TIMES_KEY . $id;

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
    
    /**
     * 更新记录所属分类
     * 
     * @param integer $sid 记录ID
     * @param integer $newCategory 新分类ID
     * @return boolean
     * @throws PhException
     */
    public function updateCategory($sid, $newCategory){
        
        $record = $this->findFirst($sid);

        if( !$record ){
            throw new PhException('EShareNotExist');
        }
        
        $oldCategory = $record->category_id;
        
        $record->category_id = $newCategory;
        if( $record->update() === false ){
            throw new PhException('ESystemError');
        }

        // 更新分类的条目数
        $category = Category::findFirst( $oldCategory );
        if($category->numbers > 0){
            $category->numbers -= 1;
            $category->update();
        }
        
        $category = Category::findFirst( $newCategory );
        $category->numbers += 1;
        $category->update();

        return TRUE;
    }
}